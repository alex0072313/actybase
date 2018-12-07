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

        // Изображения
        if($request->hasFile('images')){

            foreach ($request->file('images') as $image_upload){
                $image = new Image();
                $image->filename = $image_upload->getClientOriginalName();

                $filename_without_ext = pathinfo($image->filename, PATHINFO_FILENAME);

                $dir = 'owner_imgs/'.($owner->id % 100).'/'.$owner->id.'/';
                $src_path = $dir . $image->filename;

                //Оригинал
                Storage::disk('src')->put($src_path, (string) IntervetionImage::make($image_upload)->encode());
                $src_image = Storage::disk('src')->path($src_path);

                //Обработанные
                foreach (Config::get('image.owner') as $folder => $params){
                    $ext = $params['ext'] ? $params['ext'] : $image_upload->getClientOriginalExtension();
                    $q = $params['q'] ? $params['q'] : 90;

                    $th_path = $dir . '/' . $folder . '/' . $filename_without_ext . '.' . $ext;

                    $image_prepare = IntervetionImage::make($src_image);
                    if($params['w'] && $params['h']){
                        $image_prepare->fit($params['w'], $params['h'], function ($constraint) {
                            $constraint->upsize();
                        });
                    }
                    Storage::disk('public')->put($th_path, $image_prepare->encode($ext, $q));
                }

                $owner->images()->save($image);
            }
        }

        if($owner->update($request->all()) ){
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
}
