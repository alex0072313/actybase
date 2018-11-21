<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Панель управления', route('home'));
});

Breadcrumbs::for('user.list', function ($trail) {
    $trail->parent('home');
    $trail->push('Список менеджеров', route('user.list'));
});

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