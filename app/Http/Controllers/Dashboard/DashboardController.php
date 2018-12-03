<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller as ParentController;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;

abstract class DashboardController extends ParentController
{
    use ValidatesRequests;

    protected
        $title,
        $pagetitle,
        $pagetitle_desc,
        $view,
        $data,
        $company;

    public function __construct(){
        $this->checkUser();
    }

    public function render()
    {

        $this->data['title'] = $this->title;
        $this->data['pagetitle'] = $this->pagetitle ? $this->pagetitle : $this->title;
        $this->data['pagetitle_desc'] = $this->pagetitle_desc ? $this->pagetitle_desc : '';

        return view($this->view)->with($this->data);
    }

    protected function checkUser()
    {
        $this->middleware(function ($request, $next) {

            if(!Auth::user()->hasRole('megaroot')){
                $this->company = Auth::user()->company;
            }

            if($this->company){
                //статус - не активна
                if(!$this->company->status){

                    //отправляем уведомление
                    NotificationRepository::CompanyStatusInnactive(Auth::user());

                    if(Request::route()->getName() != 'home'){
                        return redirect()
                            ->route('home')
                            ->with('company_status_off', $this->company);
                    }else{
                        session(['company_status_off'=> $this->company]);
                    }
                }else{
                    session(['company_status_off'=> '']);
                }

                //статус активно но время работы истекло
                if($this->company->status){
                    $bestbefore = new Carbon($this->company->bestbefore);

                    if($bestbefore < Carbon::now()->addWeek()){
                        //отправляем уведомление о скором окончании
                        NotificationRepository::CompanyBestbeforeSoonEnd(Auth::user(), $this->company);
                    }

                    if($bestbefore < Carbon::now()){

                        //отправляем уведомление об окончании
                        NotificationRepository::CompanyBestbeforeEnd(Auth::user());

                        if(Request::route()->getName() != 'home'){
                            return redirect()
                                ->route('home')
                                ->with('company_innactive', $this->company);
                        }else{
                            session(['company_innactive'=> $this->company]);
                        }
                    }else{
                        session(['company_innactive'=> '']);
                    }
                }
            }

            return $next($request);
        });
    }

}
