<?php

$route->group(['middleware' => ['api']], function () use ($route) {

    $route->group(['prefix' => 'ibge'], function () use ($route) {

        $route->get('cities/{state}', 'Ibge\\City\\CityController@getByState');

    });

    $route->group(['prefix' => 'customers', 'as' => 'customers.'], function () use ($route) {

        $route->group(['prefix' => 'addresses', 'as' => 'addresses.'], function () use ($route) {

            $route->post('/', 'Customer\\Address\\AddressController@store')->name('store');
            $route->post('/{address}', 'Customer\\Address\\AddressController@update')->name('update');

        });

    });

});