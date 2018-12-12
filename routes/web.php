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
    Route::middleware('role:megaroot|boss')->group(function () {
        Route::get('/categories/{category}/destroy', 'Dashboard\CategoryController@destroy')->name('categories.destroy');
        Route::resource('categories', 'Dashboard\CategoryController')
            ->except(['destroy', 'show']);
    });

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
    Route::resource('fields', 'Dashboard\FieldController');

    Route::get('fieldtypes/{field}/destroy', 'Dashboard\FieldtypeController@destroy')->name('fieldtypes.destroy');
    Route::resource('fieldtypes', 'Dashboard\FieldtypeController')
        ->except(['destroy']);

    //Выход с кабинета
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});

Route::middleware('guest')->group(function () {
    //Вход, регистрация, восстановление пароля
    Auth::routes();
});



