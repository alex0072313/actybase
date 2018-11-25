<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Http\Middleware\UserAccessMiddleware;
use Spatie\Permission\Models\Role;

use App\Notifications\toNewManagerNotification;
use Storage;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Auth;

class UserController extends DashboardController
{
    public function __construct()
    {
        $this->middleware(['role:boss|megaroot'])->only(['create', 'index', 'store', 'destroy']);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->view = 'pages.user.list';

        $this->title = 'Список менеджеров';

        $this->data['managers'] = Auth::user()->company->managers();

        return $this->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->view = 'pages.user.add';

        $this->title = 'Добавление нового менеджера';

        return $this->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('user_primary_error', 'Ошибка при сохранении данных!');
        }

        // Валидация прошла ..
        $new_password = str_random(8);

        $to_save = $request->toArray();
        $to_save['password'] = Hash::make($new_password);
        $to_save['company_id'] = Auth::user()->company->id;

        if($newuser = User::create($to_save)){
            //Назначаем роль менеджера
            if($role = Role::where('name', config('role.names.manager.name'))->get()){
                $newuser->assignRole(config('role.names.manager.name'));
            }

            $newuser->notify(new toNewManagerNotification($newuser->email, $new_password));
        }

        //Фото
        if($img = $request->file('avatar')){
            UserRepository::createThumb($img, $newuser);
        }

        return redirect()
            ->route('user.list')
            ->with('gritter', [
                'title' => 'Менеджер был успешно добавлен!',
                'msg' => 'Email для входа: '.$request->get('email').'<br>Пароль: '.$new_password
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        $this->view = 'pages.user.profile';

        $this->title = 'Профиль пользователя';

        return $this->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->view = 'pages.user.edit';

        $this->title = 'Редактировать профиль';

        $this->data['user'] = $user;

        return $this->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(!$request->get('change_password')){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('user_primary_error', 'Ошибка при обновлении данных!');
            }

            // Валидация прошла ..

            //Фото
            if($img = $request->file('avatar')){
                UserRepository::createThumb($img, $user);
            }

            if($user->update($request->toArray())){
                return redirect()
                    ->back()
                    ->with('user_primary_success', 'Данные успешно обновлены!');
            }


        }else{

            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6|confirmed',
            ]);

            if($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('user_pass_error', 'Ошибка при обновлении пароля!');
            }

            // Валидация прошла ..
            if($user->update(['password' => Hash::make($request->get('password'))])){
                return redirect()
                    ->back()
                    ->with('user_pass_success', 'Пароль успешно обновлен!');
            }


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            return redirect()
                ->back()
                ->with('gritter', [
                    'title' => 'Менеджер был удален!',
                    'msg'=> 'Вы только что удалили менеджера '.$user->name
                ]);
        }
    }

    public function _list(){
        $this->view = 'pages.user._list';
        $this->title = 'Все пользователи';

        $users = User::rightJoin('companies', 'users.company_id', '=', 'companies.id')
            ->orderBy('companies.name', 'asc')
            ->select('users.*')
            ->get();

        $this->data['users'] = $users;

        return $this->render();
    }

    public function _edit(User $user)
    {
        $this->view = 'pages.user._edit';
        $this->title = 'Редактировать профиль';

        $this->data['user'] = $user;

        return $this->render();
    }

    public function _update(Request $request, User $user)
    {
        if(!$request->get('change_password')){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('user_primary_error', 'Ошибка при обновлении данных!');
            }

            // Валидация прошла ..

            if($request->get('role') && config('role.names.'.$request->get('role').'.name')){
                foreach ($user->roles as $role){
                    $user->removeRole($role->name);
                }
                $user->assignRole($request->get('role'));
            }

            //Фото
            if($img = $request->file('avatar')){
                UserRepository::createThumb($img, $user);
            }

            if($user->update($request->toArray())){
                return redirect()
                    ->back()
                    ->with('user_primary_success', 'Данные успешно обновлены!');
            }
        }else{

            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6|confirmed',
            ]);

            if($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('user_pass_error', 'Ошибка при обновлении пароля!');
            }

            // Валидация прошла ..
            if($user->update(['password' => Hash::make($request->get('password'))])){
                return redirect()
                    ->back()
                    ->with('user_pass_success', 'Пароль успешно обновлен!');
            }

        }
    }

    public function _destroy(User $user)
    {
        if($user->delete()){
            return redirect()
                ->route('_user_list')
                ->with('gritter', [
                    'title' => 'Менеджер был удален!',
                    'msg'=> 'Вы только что удалили менеджера '.$user->name
                ]);
        }
    }




}
