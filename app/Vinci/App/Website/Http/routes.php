<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm')->name('login.show');
    $route->post('login', 'Auth\\AuthController@login')->name('login');
    $route->get('logout', 'Auth\\AuthController@logout')->name('logout');
    $route->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $route->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $route->post('password/reset', 'Auth\PasswordController@reset');

    $route->get('/', 'Home\HomeController@index')->name('index');

    $route->get('/account/create', 'Account\AccountController@create');
    $route->post('/account/save', 'Account\AccountController@store');

    $route->group(['middleware' => ['auth:website']], function() use ($route) {

        $route->group(['prefix' => 'minha-conta', 'as' => 'account.'], function() use ($route) {

            $route->get('/', 'Account\AccountController@index')->name('index');
            $route->get('/editar', 'Account\AccountController@edit')->name('edit');

            $route->group(['prefix' => 'pedidos', 'as' => 'orders.'], function() use ($route) {

                $route->get('/', 'Account\Order\OrderController@index')->name('index');

            });

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

    $route->get('/carrinho', function(){
        return view("website::cart.index");
    });

    $route->get('/entrega', function(){
        return view("website::delivery.index");
    });

    $route->get('/pagamento', function(){
        return view("website::payment.index");
    });

    $route->get('/confirmacao', function(){
        return view("website::confirmation.index");
    });

    $route->get('/login', function(){
        return view("website::login.index");
    });

    $route->get('/fale-conosco', function(){
        return view("website::contact.index");
    });

    $route->get('/minhaconta-cadastro', function(){
        return view("website::my-account-data.index");
    });

    $route->get('/minhaconta-pedidos', function(){
        return view("website::my-account-requests.index");
    });

    $route->get('/minhaconta-enderecos', function(){
        return view("website::my-account-address.index");
    });

    $route->get('/minhaconta-favoritos', function(){
        return view("website::my-favorite-account.index");
    });



});