<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm');
    $route->post('login', 'Auth\\AuthController@login');
    $route->get('logout', 'Auth\\AuthController@logout');

    $route->group(['middleware' => ['auth:cms']], function() use ($route) {

        $route->get('/', 'Dashboard\\DashboardController@index');

        $route->group(['prefix' => 'minha-conta', 'as' => 'account.'], function() use ($route) {

            $route->get('/', 'Account\\AccountController@index')->name('index');
            $route->get('/editar', 'Account\\AccountController@edit')->name('edit');

        });

    });

});