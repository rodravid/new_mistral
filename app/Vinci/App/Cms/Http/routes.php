<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm')->name('login.show');
    $route->post('login', 'Auth\\AuthController@login')->name('login');
    $route->get('logout', 'Auth\\AuthController@logout')->name('logout');
    $route->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $route->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $route->post('password/reset', 'Auth\PasswordController@reset');

    $route->group(['middleware' => ['auth:cms']], function() use ($route) {

        $route->get('profile', 'Account\\AccountController@index')->name('profile');

        $route->group(['middleware' => ['acl']], function() use ($route) {

            $route->get('/', 'Dashboard\\DashboardController@index')->name('dashboard');

            $route->group(['prefix' => 'users', 'as' => 'users.'], function () use ($route) {
                $route->get('/', 'User\\UserController@index')->name('list');
                $route->get('/create', 'User\\UserController@create')->name('create');
                $route->get('/datatable', 'User\\UserController@datatable')->name('datatable');
            });

            $route->group(['prefix' => 'minha-conta', 'as' => 'account.'], function () use ($route) {
                $route->get('/', 'Account\\AccountController@index')->name('index');
                $route->get('/editar', 'Account\\AccountController@edit')->name('edit');
            });

        });

    });

});