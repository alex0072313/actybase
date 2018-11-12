<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller as ParentController;

class DashboardController extends ParentController
{
    protected
        $title,
        $page_title,
        $view,
        $data;

    public function __construct(){

    }

    public function render(){
        return view($this->view)->with($this->data);
    }

}
