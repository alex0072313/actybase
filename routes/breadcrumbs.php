<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Панель управления', route('home'));
});

Breadcrumbs::for('user.list', function ($trail) {
    $trail->parent('home');
    $trail->push('Список менеджеров', route('user.list'));
});

//megaroot
Breadcrumbs::for('_company_list', function ($trail) {
    $trail->parent('home');
    $trail->push('Список компаний', route('_company_list'));
});
Breadcrumbs::for('_company_edit', function ($trail, $company) {
    $trail->parent('_company_list');
    $trail->push('Компания', route('_company_edit', $company));
});

Breadcrumbs::for('_user_list', function ($trail) {
    $trail->parent('home');
    $trail->push('Список пользователей', route('_user_list'));
});
Breadcrumbs::for('_user_edit', function ($trail, $user) {
    $trail->parent('_user_list');
    $trail->push('Редактирование пользователя', route('_user_edit', $user));
});
//

//Категории
Breadcrumbs::for('categories.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Категории обьектов', route('categories.index'));
});
Breadcrumbs::for('categories.edit', function ($trail, $category) {
    $trail->parent('categories.index');
    $trail->push('Редактирование категории', route('categories.edit', $category->id));
});
Breadcrumbs::for('categories.create', function ($trail) {
    $trail->parent('categories.index');
    $trail->push('Создание категории', route('categories.create'));
});
//

//Обьекты
Breadcrumbs::for('owners.index', function ($trail, $category = false) {
    $trail->parent('home');
    $trail->push('Обьекты'.($category ? (': '.$category->name) : ''), ($category ? route('owners.index', 'category_'.$category->id) : route('owners.index')) );
});
Breadcrumbs::for('owners.edit', function ($trail, $owner) {
    $trail->parent('owners.index');
    $trail->push('Редактирование обьекта', route('owners.edit', 'owner_'.$owner->id));
});
Breadcrumbs::for('owners.create', function ($trail) {
    $trail->parent('owners.index');
    $trail->push('Создание обьекта', route('owners.create'));
});
Breadcrumbs::for('owners.create_in_cat', function ($trail, $category) {
    $trail->parent('owners.index', $category);
    $trail->push('Создание обьекта', route('owners.create_in_cat', 'category_'.$category->id));
});
//

//Поля
Breadcrumbs::for('fields.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Поля обьектов', route('fields.index'));
});
Breadcrumbs::for('fields.edit', function ($trail, $field) {
    $trail->parent('fields.index');
    $trail->push('Редактирование поля', route('fields.edit', $field->id));
});
Breadcrumbs::for('fields.create', function ($trail) {
    $trail->parent('fields.index');
    $trail->push('Создание поля', route('fields.create'));
});
//

Breadcrumbs::for('user_company', function ($trail) {
    $trail->parent('home');
    $trail->push('Компания', route('user_company'));
});

Breadcrumbs::for('user.edit', function ($trail, $user) {
    if(!Auth::user()->hasRole('boss')){
        $trail->parent('home');
    }else{
        $trail->parent('user.list');
    }
    $trail->push('Редактировать профиль ', route('user.edit', ['user' => $user]));
});

Breadcrumbs::for('user.add', function ($trail) {
    $trail->parent('user.list');
    $trail->push('Добавить менеджера', route('user.add'));
});