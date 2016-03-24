<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm');
    $route->post('login', 'Auth\\AuthController@login');
    $route->get('logout', 'Auth\\AuthController@logout');

    $route->get('password/reset/{token?}', 'Auth\\PasswordController@showResetForm');
    $route->post('password/email', 'Auth\\PasswordController@sendResetLinkEmail');
    $route->post('password/reset', 'Auth\\PasswordController@reset');

    $route->get('/', 'Home\\HomeController@index');

    $route->get('/account/create', 'Account\\AccountController@create');
    $route->post('/account/save', 'Account\\AccountController@store');

    $route->group(['middleware' => ['auth:website']], function() use ($route) {

        $route->group(['prefix' => 'minha-conta', 'as' => 'account.'], function() use ($route) {

            $route->get('/', 'Account\\AccountController@index')->name('index');
            $route->get('/editar', 'Account\\AccountController@edit')->name('edit');

        });

    });

    $route->get('/busca', function(){
        return view("website::search.index");
    });

    $route->get('/cadastro', function(){
        return view("website::register.index");
    });

    $route->get('/categoria', function(){
        return view("website::category.index");
    });

    $route->get('/produto', function(){
        return view("website::product.index");
    });

    $route->get('/paginas', function(){
        return view("website::list-page.index");
    });

});