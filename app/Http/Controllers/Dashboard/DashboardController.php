<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller as ParentController;

class DashboardController extends ParentController
{
    protected
        $title,
        $pagetitle,
        $view,
        $data;

    public function __construct(){

    }

    public function render(){

        $this->data['title'] = $this->title;
        $this->data['pagetitle'] = $this->pagetitle ? $this->pagetitle : $this->title;

        return view($this->view)->with($this->data);
    }

}
