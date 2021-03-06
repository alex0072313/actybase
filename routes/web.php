<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['role:megaroot']], function () {

    //Список компаний
    Route::get('/_companies', 'Dashboard\CompanyController@_list')->name('_company_list');
    Route::get('/_companies/{company}', 'Dashboard\CompanyController@_edit')->name('_company_edit');
    Route::post('/_companies/{company}', 'Dashboard\CompanyController@_update')->name('_company_update');
    Route::get('/_companies/{company}/destroy', 'Dashboard\CompanyController@_destroy')->name('_company_destroy');

    //Список пользователей
    Route::get('/_users', 'Dashboard\UserController@_list')->name('_user_list');
    Route::get('/_users/{user}', 'Dashboard\UserController@_edit')->name('_user_edit');
    Route::post('/_users/{user}', 'Dashboard\UserController@_update')->name('_user_update');
    Route::get('/_users/{user}/destroy', 'Dashboard\UserController@_destroy')->name('_user_destroy');

});


Route::middleware('auth')->group(function () {

    //Главная
    Route::get('/', 'Dashboard\HomeController@index')->name('home');

    //Пользователи
    Route::get('/users/{user}/destroy', 'Dashboard\UserController@destroy')->name('users.destroy');
    Route::resource('users', 'Dashboard\UserController', [
        'names' => [
            'index' => 'user.list',
            'show' => 'user.profile',
            'edit' => 'user.edit',
            'update' => 'user.update',
            'create' => 'user.add',
        ]
    ])->except('destroy');

    //Компания
    Route::match(['get', 'post'], '/company', 'Dashboard\CompanyController@any')
        ->name('user_company')
        ->middleware('role:megaroot|boss');

    //Категории обьектов (управление)
    //Route::middleware('role:megaroot|boss')->group(function () {
        Route::get('/categories/{category}/destroy', 'Dashboard\CategoryController@destroy')->name('categories.destroy');
        Route::resource('categories', 'Dashboard\CategoryController')
            ->except(['destroy', 'show']);
    //});

    //Обьекты
    Route::get('owners/create', 'Dashboard\OwnerController@create')->name('owners.create');
    Route::get('owners/{category_str_id?}', 'Dashboard\OwnerController@index')->name('owners.index');
    Route::get('owners/{category_str_id}/create', 'Dashboard\OwnerController@create')->name('owners.create_in_cat');
    Route::get('owners/{owner_str_id}/destroy', 'Dashboard\OwnerController@destroy')->name('owners.destroy');
    Route::resource('owners', 'Dashboard\OwnerController')
        ->except(['index', 'create', 'destroy'])
        ->parameters([
            'owners' => 'owner_str_id'
        ]);

    //Изображения
    Route::delete('/owners_images_destroy/{image}', 'Dashboard\ImageController@destroy')->name('image.destroy');

    //Дополнительные поля
    Route::get('fields/create', 'Dashboard\FieldController@create')->name('fields.create');
    Route::get('fields/{category_str_id?}', 'Dashboard\FieldController@index')->name('fields.index');
    Route::get('fields/{category_str_id}/create', 'Dashboard\FieldController@create')->name('fields.create_in_cat');
    Route::get('fields/{field_str_id}/destroy', 'Dashboard\FieldController@destroy')->name('fields.destroy');
    Route::post('fields/get_for_owner/{owner_str_id?}', 'Dashboard\FieldController@getForOwner')->name('fields.get_for_owner');

    Route::post('fields/upload_files/{owner_str_id}', 'Dashboard\FieldController@uploadFiles')->name('fields.upload_files');

    Route::post('fields/remove_exist_file/{file}', 'Dashboard\FieldController@removeExistFile')->name('fields.rm_exist_file');

    Route::resource('fields', 'Dashboard\FieldController')
        ->except(['index', 'create', 'destroy'])
        ->parameters([
            'fields' => 'field_str_id'
        ]);

    //Выход с кабинета
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});

Route::middleware('guest')->group(function () {
    //Вход, регистрация, восстановление пароля
    Auth::routes();
});



