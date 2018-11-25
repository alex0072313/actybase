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