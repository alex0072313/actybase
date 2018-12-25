<?php

namespace App\Http\Controllers\Dashboard;

use App\File;
use App\Owner;
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
            $this->data['category'] = $category;
            $fields = $category->fields;
            $this->pagetitle_desc = $category->name;
        }else{
            $this->pagetitle_desc = 'Все категории';
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
    public function create(Category $category)
    {
        $this->view = 'pages.field.form';
        $this->title = 'Создание нового поля';

        if($category){
            $this->pagetitle_desc = $category->name;
            $this->data['category'] = $category;
        }

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

    public function getFieldsForOwner(Owner $owner, Category $category)
    {
        $category_fields = Category::find($category->id ? $category->id : request()->get('category_id'))->fields;

        $fields = $category_fields->map(function ($field) use ($owner){
            $fieldcontent = $owner->fields()->where('field_id', $field->id)->first();

            $data = [];

            if($field->type->type == 'files'){
                foreach ($owner->files()->where('field_id', $field->id)->get() as $file){
                    $data['files'][$file->id] = $file->filename;
                }
            }

            $data['label'] = $field->name;
            $data['name'] = 'field['.$field->id.']';
            if($fieldcontent){
                $data['value'] = $fieldcontent->content;
                $data['data'] = $fieldcontent->data;
            }

            return view('includes.field.field_'.$field->type->type)
                ->with($data)
                ->render();
        });

        return $fields;
    }

    public function getForOwner(Owner $owner, Category $category)
    {
        $this->data['fields'] = $this->getFieldsForOwner($owner, $category);
        return $this->json();
    }

    public function uploadFiles(Request $request)
    {
        $this->data['files'] = [[
            'name' => $request->file('uploads')->getClientOriginalName(),
            'size' => $request->file('uploads')->getClientSize()
        ]];
        return $this->json();
    }

    public function removeExistFile(File $file)
    {
        if($file->delete()){
            $this->data['success']['filename'] = $file->filename;
        }

        return $this->json();
    }
}
