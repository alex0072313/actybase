<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends DashboardController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->view = 'pages.category.list';
        $this->title = 'Категории обьектов';

        $this->data['categories'] = Category::allToAccess();

        return $this->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->view = 'pages.category.form';
        $this->title = 'Добавление новой категории';

        return $this->render();
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
        ]);

        if($validate->fails()){
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('category_error', 'Ошибка при создании категории!');
        }

        if($request->input('parent_id') == 0){
            $request->request->set('parent_id', null);
        }

        if(auth()->user()->categories()->create($request->all())){
            return redirect()
                ->route('categories.index')
                ->with('gritter', [
                    'title' => 'Категория была успешно добавлена!',
                ]);
        }
    }

    public function edit(Category $category)
    {
        $this->authorize('access', $category);

        $this->view = 'pages.category.form';
        $this->title = 'Редактирование категории '.$category->name;

        $this->data['category'] = $category;

        return $this->render();
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('access', $category);

        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
        ]);

        if($validate->fails()){
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('category_error', 'Ошибка при обновлении данных!');
        }

        if($request->input('parent_id') == 0){
            $request->request->set('parent_id', null);
        }

        if($category->update($request->all())){
            return redirect()
                ->back()
                ->with('category_success', 'Данные успешно обновлены!');
        }

    }

    public function destroy(Category $category)
    {
        $this->authorize('access', $category);

        if($category->delete()){

            return redirect()
                ->back()
                ->with('gritter', [
                    'title' => 'Категория была удалена!',
                    'msg'=> 'Вы только что удалили категорию '.$category->name
                ]);
        }
    }

}
