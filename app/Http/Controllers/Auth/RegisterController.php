<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Http\Requests\RegisterRequest;
use App\Notifications\NewUserRegister;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = route('home');
    }

    public function showRegistrationForm()
    {
        return view('pages.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(RegisterRequest $request)
    {
        //Создаем компанию
        $company = Company::create();
        $user = $company->users()->create($request->all());

        //Назначаем роль директора
        if($role = Role::where('name', config('role.names.boss.name'))->get()){
            $user->assignRole(config('role.names.boss.name'));
        }

        //Уведомление админу
        $this->mail_to_admin_new_user($user);

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function mail_to_admin_new_user(User $new_user){
        $users = User::with('roles')->get();
        $megaroots = $users->reject(function ($user, $key) {
            if($user->hasRole('megaroot')){
                return false;
            }
            return true;
        });

        foreach ($megaroots as $megaroot){
            $megaroot->notify(new NewUserRegister($new_user));
        }

    }

}
