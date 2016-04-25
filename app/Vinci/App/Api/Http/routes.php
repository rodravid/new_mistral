<?php

$route->group(['middleware' => ['api']], function () use ($route) {

    $route->group(['prefix' => 'ibge'], function () use ($route) {

        $route->get('cities/{state}', 'Ibge\\City\\CityController@getByState');

    });

});