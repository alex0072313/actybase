<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Image;
use App\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Storage;
use Image as IntervetionImage;
use Config;

class OwnerController extends DashboardController
{
    public function index(Category $category)
    {
        $this->view = 'pages.owner.list';
        $this->title = 'Обьекты';

        $this->pagetitle = 'Обьекты';

        if($category->name){
            $this->title = 'Обьекты в категории - '.$category->name;
            $this->pagetitle_desc = $category->name;

            $this->data['category'] = $category;
        }

        $this->data['owners'] = Owner::all();

        return $this->render();
    }

    public function create(Category $category)
    {
        $this->view = 'pages.owner.form';
        $this->title = 'Добавление нового обьекта';

        if($category){
            $this->pagetitle_desc = $category->name;
            $this->data['category'] = $category;
        }

        return $this->render();
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'category_id' => 'required',
        ]);

        if($validate->fails()){
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('error', 'Ошибка при создании обьекта, проверьте форму!');
        }

        if($company = auth()->user()->company){
            $request->request->set('company_id', $company->id);
        }

        if($request->input('parent_id') == 0){
            $request->request->set('parent_id', null);
        }

        if($owner = Auth::user()->owners()->create($request->all())){

            //Изображения
            $this->images($owner);

            return redirect()
                ->route('owners.index', 'category_'.$owner->category->id)
                ->with('gritter', [
                    'title' => 'Обьект был успешно обновлен!',
                    'msg' => 'Обьект <a class=\"text-green\" href=\"'.route('owners.edit', $owner->id).'\">'.$owner->name.'</a> добавлен в категорию ' .
                        (Auth::user()->can('access', $owner->category) ? '<a class=\"text-green\" href=\"'.route('categories.edit', $owner->category->id).'\">' : '').
                            $owner->category->name.
                        (Auth::user()->can('access', $owner->category) ? '</a>' : '')
                ]);
        }


    }

    public function show(Owner $owner)
    {
        //
    }

    public function edit(Owner $owner)
    {
        $this->view = 'pages.owner.form';
        $this->title = 'Обьект: '.$owner->name;

        $this->pagetitle = $owner->name;

        if($category = $owner->category){
            $this->pagetitle_desc = $category->name;
        }

        $this->data['owner'] = $owner;

        return $this->render();
    }

    public function update(Request $request, Owner $owner)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'category_id' => 'required',
        ]);

        if($validate->fails()){
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('error', 'Ошибка при обновлении обьекта, проверьте форму!');
        }

        if($request->input('category_id') == 0){
            $request->request->set('category_id', null);
        }

        if($company = auth()->user()->company){
            $request->request->set('company_id', $company->id);
        }

        if($request->input('parent_id') == 0){
            $request->request->set('parent_id', null);
        }

        if($owner->update($request->all()) ){

            //Изображения
            $this->images($owner);

            return redirect()
                ->route('owners.index')
                ->with('gritter', [
                    'title' => 'Обьект был успешно обновлен!',
                ]);
        }

    }

    public function destroy(Owner $owner)
    {
        if($owner->delete()){
            return redirect()
                ->route('owners.index', 'category_'.$owner->category->id)
                ->with('gritter', [
                    'title' => 'Обьект был удален!',
                    'msg'=> 'Вы только что удалили обьект '.$owner->name
                ]);
        }
    }

    protected function images(Owner $owner)
    {
        // Изображения
        $images_pos = request()->get('images_pos');

        // Сортировка существующих
        if($images_pos) {
            foreach ($images_pos as $image_name => $pos) {
                $owner->images()->where('filename', $image_name)->update(['pos' => $pos]);
            }
        }
        //

        if(request()->hasFile('images')){
            foreach (request()->file('images') as $image_upload){
                $pos = $images_pos[$image_upload->getClientOriginalName()];
                $owner->images()->save(new Image(['file' => $image_upload, 'pos' => $pos]));
            }
        }
    }

}
