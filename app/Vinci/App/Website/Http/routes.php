<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->group(['middleware' => ['auth:website']], function() use ($route) {

        /**
         * Account
         */
        $route->group(['prefix' => 'minhaconta', 'as' => 'account.'], function() use ($route) {

            $route->get('/', 'Account\AccountController@index')->name('index');
            $route->get('/editar', 'Account\AccountController@edit')->name('edit');
            $route->put('/{customer}', 'Account\AccountController@update')->name('update');

            /**
             * Orders
             */
            $route->group(['prefix' => 'pedidos', 'as' => 'orders.'], function() use ($route) {
                $route->get('/', 'Account\Order\OrderController@index')->name('index');
                $route->get('/{order}', 'Account\Order\OrderController@show')->name('show');
            });

            /**
             * Favorites
             */
            $route->group(['prefix' => 'favoritos', 'as' => 'favorite.'], function() use ($route) {
                $route->get('/', 'Account\Favorite\FavoriteController@index')->name('index');
            });

            /**
             * Addresses
             */
            $route->group(['prefix' => 'enderecos', 'as' => 'addresses.'], function() use ($route) {
                $route->get('/', 'Account\Addresses\AddressesController@index')->name('index');
                $route->get('/modal', 'Account\Addresses\AddressesController@getAddressModal')->name('modal');
            });

        });

        /**
         * Checkout
         */
        $route->group(['prefix' => 'checkout', 'as' => 'checkout.', 'middleware' => ['check-cart']], function() use ($route) {

            /**
             * Delivery
             */
            $route->group(['prefix' => 'entrega', 'as' => 'delivery.'], function() use ($route) {
                $route->get('/', 'Checkout\Delivery\DeliveryController@index')->name('index');
            });

            /**
             * Payment
             */
            $route->group(['prefix' => 'pagamento', 'as' => 'payment.'], function() use ($route) {
                $route->get('/', 'Checkout\Payment\PaymentController@index')->name('index');
            });

            /**
             * Confirmation
             */
            $route->group(['prefix' => 'confirmacao', 'as' => 'confirmation.'], function() use ($route) {
                $route->get('/{order}', 'Checkout\Confirmation\ConfirmationController@index')->name('index');
            });

        });

        /**
         * Order
         */
        $route->group(['prefix' => 'order', 'as' => 'order.'], function() use ($route) {
            $route->post('/', 'Order\OrderController@store')->name('store');
        });

        /**
         * API
         */
        $route->group(['prefix' => 'api', 'as' => 'api.'], function() use ($route) {

            /**
             * Product
             */
            $route->group(['prefix' => 'product', 'as' => 'product.'], function() use ($route) {
                $route->post('{product}/favorite', 'Product\ProductController@favorite')->name('favorite');
            });

        });

    });

    /*
     * Home
     */
    $route->get('/', 'Home\HomeController@index')->name('index');

    /**
     * Register
     */
    $route->group(['prefix' => 'cadastro', 'as' => 'register.'], function() use ($route) {
        $route->get('/', 'Register\RegisterController@index')->name('index');
        $route->post('/', 'Register\\RegisterController@store')->name('store');
    });

    /**
     * Search
     */
    $route->group(['prefix' => 'busca', 'as' => 'search.'], function() use ($route) {
        $route->get('/', 'Search\SearchController@index')->name('index');
    });

    /**
     * Product
     */
    $route->group(['prefix' => 'p', 'as' => 'product.'], function() use ($route) {
        $route->get('/{type}/{slug}', 'Product\ProductController@show')->name('index');
    });

    /**
     * Category
     */
    $route->group(['prefix' => 'c', 'as' => 'category.'], function() use ($route) {

        $route->group(['prefix' => 'pais', 'as' => 'country.'], function() use ($route) {
            $route->get('/{slug}', 'Country\CountryController@show')->name('show');
        });

        $route->group(['prefix' => 'regiao', 'as' => 'region.'], function() use ($route) {
            $route->get('/{slug}', 'Region\RegionController@show')->name('show');
        });

        $route->group(['prefix' => 'produtor', 'as' => 'producer.'], function() use ($route) {
            $route->get('/{slug}', 'Producer\ProducerController@show')->name('show');
        });

    });

    /**
     * Shopping cart
     */
    $route->group(['prefix' => 'carrinho', 'as' => 'cart.'], function() use ($route) {
        $route->get('/', 'ShoppingCart\ShoppingCartController@index')->name('index');

        $route->group(['prefix' => 'items', 'as' => 'items.'], function() use ($route) {

            $route->get('/', 'ShoppingCart\ShoppingCartController@getItems')->name('index');
            $route->post('add', 'ShoppingCart\ShoppingCartController@add')->name('add');
            $route->post('{item}/sync', 'ShoppingCart\ShoppingCartController@syncQuantity')->name('sync');
            $route->delete('{item}/remove', 'ShoppingCart\ShoppingCartController@removeItem')->name('remove');

        });
    });

    /**
     * API
     */
    $route->group(['prefix' => 'api', 'as' => 'api.'], function() use ($route) {

        /**
         * Showcase
         */
        $route->group(['prefix' => 'showcase', 'as' => 'showcase.'], function() use ($route) {
            $route->get('{showcase}/products', 'Showcase\ShowcaseController@getProducts')->name('products');
        });

        /**
         * Newsletter
         */
        $route->group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function() use ($route) {
            $route->post('register', 'Newsletter\NewsletterController@store')->name('register');
        });

    });


    /**
     * Contact
     */
    $route->group(['prefix' => 'fale-conosco', 'as' => 'contact.'], function() use ($route) {
        $route->get('/', 'Contact\ContactController@index')->name('index');
        $route->post('/', 'Contact\ContactController@store')->name('store');
    });

    /**
     * Site pages
     */
    $route->get('/paginas', 'Pages\PagesController@index');
    $route->get('/privacidade', 'Pages\PagesController@privacy')->name('privacy.index');
    $route->get('/duvidas-frequentes', 'Pages\PagesController@frequentDoubts')->name('frequent-doubts.index');
    $route->get('/sobre-vinci', 'Pages\PagesController@about')->name('about.index');
    $route->get('/revendedores', 'Pages\PagesController@dealers')->name('dealers.index');

    /**
     * Auth
     */
    $route->get('login', 'Auth\\AuthController@showLoginForm')->name('login.show');
    $route->post('login', 'Auth\\AuthController@login')->name('login');
    $route->get('logout', 'Auth\\AuthController@logout')->name('logout');
    $route->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('password.index');
    $route->post('password/email', 'Auth\PasswordController@sendResetLinkEmail')->name('password.email');
    $route->post('password/reset', 'Auth\PasswordController@reset')->name('password.reset');

});