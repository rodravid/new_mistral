<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm');
    $route->post('login', 'Auth\\AuthController@login');
    $route->get('logout', 'Auth\\AuthController@logout');

    $route->group(['middleware' => ['auth:website']], function() use ($route) {

        $route->get('/minha-conta', function() {

            dd(auth('website')->user());

        });

    });

    $route->get('/', 'Home\\HomeController@index');

});