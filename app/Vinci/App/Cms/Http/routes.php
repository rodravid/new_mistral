<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm')->name('login.show');
    $route->post('login', 'Auth\\AuthController@login')->name('login');
    $route->get('logout', 'Auth\\AuthController@logout')->name('logout');
    $route->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $route->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $route->post('password/reset', 'Auth\PasswordController@reset');

    $route->group(['middleware' => ['auth:cms']], function() use ($route) {

        $route->group(['middleware' => ['cms']], function() use ($route) {

            $route->get('/', 'Dashboard\\DashboardController@index')->name('dashboard.show');
            $route->get('profile', 'Account\\AccountController@index')->name('profile');
            $route->get('password/help', 'Auth\PasswordController@help')->name('password.help');

        });

        $route->group(['middleware' => ['cms','acl']], function() use ($route) {

            /**
             * Countries
             */
            $route->group(['prefix' => 'countries', 'as' => 'countries.'], function () use ($route) {
                $route->get('/', 'Country\\CountryController@index')->name('list');
                $route->get('/create', 'Country\\CountryController@create')->name('create');
                $route->post('/', 'Country\\CountryController@store')->name('create#store');
                $route->get('/{country}/edit', 'Country\\CountryController@edit')->name('edit');
                $route->delete('/{country}/delete', 'Country\\CountryController@destroy')->name('destroy');
                $route->put('/{country}', 'Country\\CountryController@update')->name('edit#update');
                $route->delete('/{country}/image/{image}/delete', 'Country\\CountryController@removeImage')->name('edit#remove-image');
                $route->get('datatable', 'Country\\CountryController@datatable')->name('list#datatable');
            });

            /**
             * Regions
             */
            $route->group(['prefix' => 'regions', 'as' => 'regions.'], function () use ($route) {
                $route->get('/', 'Region\\RegionController@index')->name('list');
                $route->get('/create', 'Region\\RegionController@create')->name('create');
                $route->post('/', 'Region\\RegionController@store')->name('create#store');
                $route->get('/{region}/edit', 'Region\\RegionController@edit')->name('edit');
                $route->delete('/{region}/delete', 'Region\\RegionController@destroy')->name('destroy');
                $route->put('/{region}', 'Region\\RegionController@update')->name('edit#update');
                $route->delete('/{region}/image/{image}/delete', 'Region\\RegionController@removeImage')->name('edit#remove-image');
                $route->get('datatable', 'Region\\RegionController@datatable')->name('list#datatable');
            });

            /**
             * Producers
             */
            $route->group(['prefix' => 'producers', 'as' => 'producers.'], function () use ($route) {
                $route->get('/', 'Producer\\ProducerController@index')->name('list');
                $route->get('/create', 'Producer\\ProducerController@create')->name('create');
                $route->post('/', 'Producer\\ProducerController@store')->name('create#store');
                $route->get('/{producer}/edit', 'Producer\\ProducerController@edit')->name('edit');
                $route->delete('/{producer}/delete', 'Producer\\ProducerController@destroy')->name('destroy');
                $route->put('/{producer}', 'Producer\\ProducerController@update')->name('edit#update');
                $route->delete('/{producer}/image/{image}/delete', 'Producer\\ProducerController@removeImage')->name('edit#remove-image');
                $route->get('datatable', 'Producer\\ProducerController@datatable')->name('list#datatable');
            });

            /**
             * Grapes
             */
            $route->group(['prefix' => 'grapes', 'as' => 'grapes.'], function () use ($route) {
                $route->get('/', 'Grape\\GrapeController@index')->name('list');
                $route->get('/create', 'Grape\\GrapeController@create')->name('create');
                $route->post('/', 'Grape\\GrapeController@store')->name('create#store');
                $route->get('/{grape}/edit', 'Grape\\GrapeController@edit')->name('edit');
                $route->delete('/{grape}/delete', 'Grape\\GrapeController@destroy')->name('destroy');
                $route->put('/{grape}', 'Grape\\GrapeController@update')->name('edit#update');
                $route->delete('/{grape}/image/{image}/delete', 'Grape\\GrapeController@removeImage')->name('edit#remove-image');
                $route->get('datatable', 'Grape\\GrapeController@datatable')->name('list#datatable');
            });

            /**
             * Product type
             */
            $route->group(['prefix' => 'product-type', 'as' => 'product-type.'], function () use ($route) {
                $route->get('/', 'ProductType\\ProductTypeController@index')->name('list');
                $route->get('/create', 'ProductType\\ProductTypeController@create')->name('create');
                $route->post('/', 'ProductType\\ProductTypeController@store')->name('create#store');
                $route->get('/{productType}/edit', 'ProductType\\ProductTypeController@edit')->name('edit');
                $route->delete('/{productType}/delete', 'ProductType\\ProductTypeController@destroy')->name('destroy');
                $route->put('/{productType}', 'ProductType\\ProductTypeController@update')->name('edit#update');
                $route->delete('/{productType}/image/{image}/delete', 'ProductType\\ProductTypeController@removeImage')->name('edit#remove-image');
                $route->get('datatable', 'ProductType\\ProductTypeController@datatable')->name('list#datatable');
            });

            /**
             * Dollar
             */
            $route->group(['prefix' => 'dollar', 'as' => 'dollar.'], function () use ($route) {
                $route->get('/', 'Dollar\\DollarController@index')->name('list');
                $route->get('/create', 'Dollar\\DollarController@create')->name('create');
                $route->post('/', 'Dollar\\DollarController@store')->name('create#store');
                $route->get('datatable', 'Dollar\\DollarController@datatable')->name('list#datatable');
            });

            /**
             * Deadline
             */
            $route->group(['prefix' => 'deadline', 'as' => 'deadline.'], function () use ($route) {
                $route->get('/', 'Deadline\\DeadlineController@index')->name('list');
                $route->get('/create', 'Deadline\\DeadlineController@create')->name('create');
                $route->post('/', 'Deadline\\DeadlineController@store')->name('create#store');
                $route->get('datatable', 'Deadline\\DeadlineController@datatable')->name('list#datatable');
            });

            /**
             * Newsletter
             */
            $route->group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () use ($route) {
                $route->get('/', 'Newsletter\\NewsletterController@index')->name('list');
                $route->get('datatable', 'Newsletter\\NewsletterController@datatable')->name('list#datatable');
                $route->get('export', 'Newsletter\\NewsletterController@export')->name('export');
            });

            /**
             * Highlights
             */

            $route->group(['prefix' => 'highlights'], function () use ($route) {

                /**
                 * Home main slider
                 */
                $route->group(['prefix' => 'home-main-slider', 'as' => 'home-main-slider.'], function () use ($route) {
                    $route->get('/', 'Highlight\\HighlightController@index')->name('list');
                    $route->get('/create', 'Highlight\\HighlightController@create')->name('create');
                    $route->post('/', 'Highlight\\HighlightController@store')->name('create#store');
                    $route->get('/{highlight}/edit', 'Highlight\\HighlightController@edit')->name('edit');
                    $route->delete('/{highlight}/delete', 'Highlight\\HighlightController@destroy')->name('destroy');
                    $route->put('/{highlight}', 'Highlight\\HighlightController@update')->name('edit#update');
                    $route->delete('/{highlight}/photo/{photo}/delete', 'Highlight\\HighlightController@removeImage')->name('edit#remove-image');
                    $route->get('datatable', 'Highlight\\HighlightController@datatable')->name('list#datatable');
                });

            });

            /**
             * Users
             */
            $route->group(['prefix' => 'users', 'as' => 'users.'], function () use ($route) {
                $route->get('/', 'User\\UserController@index')->name('list');
                $route->get('/create', 'User\\UserController@create')->name('create');
                $route->post('/', 'User\\UserController@store')->name('create#store');
                $route->get('/{user}/edit', 'User\\UserController@edit')->name('edit');
                $route->delete('/{user}/delete', 'User\\UserController@destroy')->name('destroy');
                $route->put('/{user}', 'User\\UserController@update')->name('edit#update');
                $route->get('datatable', 'User\\UserController@datatable')->name('list#datatable');
                $route->delete('/{user}/photo/{photo}/delete', 'User\\UserController@removePhoto')->name('edit#remove-photo');
            });

            /**
             * Groups
             */
            $route->group(['prefix' => 'roles', 'as' => 'roles.'], function () use ($route) {
                $route->get('/', 'Role\\RoleController@index')->name('list');
                $route->get('/create', 'Role\\RoleController@create')->name('create');
                $route->post('/', 'Role\\RoleController@store')->name('create#store');
                $route->get('/{role}/edit', 'Role\\RoleController@edit')->name('edit');
                $route->delete('/{role}/delete', 'Role\\RoleController@destroy')->name('destroy');
                $route->put('/{role}', 'Role\\RoleController@update')->name('edit#update');
                $route->get('datatable', 'Role\\RoleController@datatable')->name('list#datatable');
            });

            $route->group(['prefix' => 'minha-conta', 'as' => 'account.'], function () use ($route) {
                $route->get('/', 'Account\\AccountController@index')->name('index');
                $route->get('/editar', 'Account\\AccountController@edit')->name('edit');
            });

        });

    });

});