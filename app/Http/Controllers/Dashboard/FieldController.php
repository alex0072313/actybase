<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Field;
use App\Category;
use Validator;

class FieldController extends DashboardController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $this->view = 'pages.field.list';
        $this->title = 'Дополнительные поля';

        if($category->name){
            $fields = $category->fields;
        }else{
            $fields = Field::all();
        }

        $this->data['fields'] = $fields;

        return $this->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->view = 'pages.field.form';
        $this->title = 'Создание нового поля';

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
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'categories' => 'required|array',
        ]);

        $validate->setAttributeNames([
            'name' => 'Название',
        ]);

        if($validate->fails()){
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('field_error', 'Ошибка при создании дополнительного поля!');
        }

        if($field = Field::create($request->all())){
            if($categories = $request->get('categories')){
                $field->categories()->sync($categories);
            }

            return redirect()
                ->route('fields.index')
                ->with('gritter', [
                    'title' => 'Добавление поля',
                    'msg' => 'Дополнительное поле было успешно создано!',
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        $this->view = 'pages.field.form';
        $this->title = 'Редактирование поля: '.$field->name;

        $this->data['field'] = $field;

        return $this->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'fieldtype_id' => 'required',
            'categories' => 'required|array',
        ]);

        $validate->setAttributeNames([
            'name' => 'Название',
        ]);

        if($validate->fails()){
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('field_error', 'Ошибка при редактировании дополнительного поля!');
        }

        if($categories = $request->get('categories')){
            $field->categories()->sync($categories);
        }

        if($field->update($request->all())){
            return redirect()
                ->route('fields.index')
                ->with('gritter', [
                    'title' => 'Обновление поля',
                    'msg' => 'Дополнительное поле было успешно обновлено!',
                ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        if($field->delete()){
            return redirect()
                ->back()
                ->with('gritter', [
                    'title' => 'Удаление поля',
                    'msg'=> 'Вы только что удалили поле '.$field->name
                ]);
        }
    }
}
