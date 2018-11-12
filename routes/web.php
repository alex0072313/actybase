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

});

Route::middleware('auth')->group(function () {

    //Главная
    Route::get('/', 'Dashboard\HomeController@index')->name('home');

    //Пользователь
    Route::resource('users', 'Dashboard\UserController', [
        'names' => [
            'index' => 'user.list',
            'show' => 'user.profile',
        ]
    ]);

    //Выход с кабинета
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});

Route::middleware('guest')->group(function () {
    //Вход, регистрация, восстановление пароля
    Auth::routes();
});



