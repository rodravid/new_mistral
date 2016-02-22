<?php

$route->get('/', function() {
    return view('welcome');
});


Route::group(['middleware' => ['web']], function () {
    //
});

$route->get('/customers', 'CustomerController@index');