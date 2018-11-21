<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Repositories\CompanyRepository;

class CompanyController extends DashboardController
{

    public function __construct()
    {
        parent::__construct();
    }

    protected $company;

    public function any(Request $request){

        $this->company = Auth::user()->company;

        if($request->isMethod('post')){
            return $this->update($request);
        }

        return $this->edit();
    }

    protected function edit(){
        $this->view = 'pages.company';
        $this->title = 'Управление компанией';

        $this->data['company'] = $this->company;

        return $this->render();
    }

    protected function update($request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('company_error', 'Ошибка при обновлении данных!');
        }

        // Валидация прошла ..

        //Фото
        if($img = $request->file('logo')){
            CompanyRepository::createThumb($img, $this->company);
        }

        if($this->company->update($request->except(['logo']))){
            return redirect()
                ->back()
                ->with('company_success', 'Данные успешно обновлены!');
        }

    }


}
