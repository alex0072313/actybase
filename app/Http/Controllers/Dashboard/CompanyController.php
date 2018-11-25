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
        $this->view = 'pages.company.edit';
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

    public function _list(){
        $this->view = 'pages.company._list';
        $this->title = 'Все компании';

        $this->data['companies'] = Company::all();

        return $this->render();
    }

    public function _edit(Company $company){
        $this->view = 'pages.company._edit';
        $this->title = 'Управление компанией';

        $this->data['company'] = $company;

        return $this->render();
    }

    public function _destroy(Company $company){
        if($company->delete()){
            $company->users()->delete();
            return redirect()
                ->route('_company_list')
                ->with('gritter', [
                    'title' => 'Менеджер был удален!',
                    'msg'=> 'Вы только что удалили компанию '.$company->name.' и всех ее пользователей'
                ]);
        }
    }

    public function _update(Request $request, Company $company){

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
            CompanyRepository::createThumb($img, $company);
        }

        if(!$request->get('status')){
            $request->request->add(['status'=> false]);
        }else{
            $request->request->set('status', true);
        }

        //dd($request->toArray());

        if($company->update($request->except(['logo']))){
            return redirect()
                ->route('_company_list')
                ->with('gritter', [
                    'title' => 'Данные успешно обновлены!',
                    'msg'=> 'Обновлена информация по компании '.$company->name
                ]);
        }

    }


}
