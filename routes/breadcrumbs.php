<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Панель управления', route('home'));
});