<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller as ParentController;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class DashboardController extends ParentController
{
    use ValidatesRequests;

    protected
        $title,
        $pagetitle,
        $view,
        $data,
        $company;

    public function __construct(){

        $this->middleware(function ($request, $next) {

            if(!Auth::user()->hasRole('megaroot')){
                $this->company = Auth::user()->company;
            }

            if($this->company){
                if($this->company->bestbefore){
                    if(Carbon::createFromFormat($this->company->bestbefore) > Carbon::now()){
                        return redirect()
                            ->route('home')
                            ->with('company_innactive', $this->company);
                    }
                }else{
                    return redirect()
                        ->route('home')
                        ->with('company_innactive', $this->company);
                }

            }

            return $next($request);
        });


    }

    public function render(){

        $this->data['title'] = $this->title;
        $this->data['pagetitle'] = $this->pagetitle ? $this->pagetitle : $this->title;

        return view($this->view)->with($this->data);
    }

}
