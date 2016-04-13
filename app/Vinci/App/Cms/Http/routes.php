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

        $route->group(['middleware' => ['cms','acl']], function() use ($route) {

            $route->get('/', 'Dashboard\\DashboardController@index')->name('dashboard');

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
             * Highlight
             */

            $route->group(['prefix' => 'highlights'], function () use ($route) {

                /**
                 * Home main slider
                 */
                $route->group(['prefix' => 'home-main-slider', 'as' => 'home-main-slider.'], function () use ($route) {
                    $route->get('/', 'Highlight\\HighlightController@index')->name('list');
                    $route->get('/create', 'Highlight\\HighlightController@create')->name('create');
                    $route->post('/', 'Highlight\\HighlightController@store')->name('create#store');
                    $route->get('/{user}/edit', 'Highlight\\HighlightController@edit')->name('edit');
                    $route->delete('/{user}/delete', 'Highlight\\HighlightController@destroy')->name('destroy');
                    $route->put('/{user}', 'Highlight\\HighlightController@update')->name('edit#update');
                    $route->delete('/{user}/photo/{photo}/delete', 'Highlight\\HighlightController@removePhoto')->name('edit#remove-photo');
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