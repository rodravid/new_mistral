<?php

$route->group(['middleware' => ['web']], function () use ($route) {

    $route->get('login', 'Auth\\AuthController@showLoginForm')->name('login.show');
    $route->post('login', 'Auth\\AuthController@login')->name('login');
    $route->get('logout', 'Auth\\AuthController@logout')->name('logout');
    $route->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $route->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $route->post('password/reset', 'Auth\PasswordController@reset');

    $route->get('test', 'TestController@index');

    $route->group(['middleware' => ['auth:cms']], function() use ($route) {

        $route->group(['middleware' => ['cms']], function() use ($route) {

            $route->get('/', 'Dashboard\\DashboardController@index')->name('dashboard.show');
            $route->get('/LineChartPedidos', 'Graphics\\GraphicsController@getDataForOrdersLineChart')->name('dashboard.order.lineChart');
            $route->get('/BarChartPedidos', 'Graphics\\GraphicsController@getDataForOrdersBarChart')->name('dashboard.orders.barChart');
            $route->get('password/help', 'Auth\PasswordController@help')->name('password.help');
            $route->post('settings/{key}/{value}', 'Settings\\SettingsController@store')->name('settings.store');
            
            /**
             * Accounts
             */
            $route->group(['prefix' => 'profile', 'as' => 'profile.'], function () use ($route) {
                $route->get('/', 'Account\\AccountController@show')->name('show');
                $route->put('/{user}', 'Account\\AccountController@update')->name('update');
            });

            $route->group(['prefix' => 'integration', 'as' => 'integration.'], function () use ($route) {
                $route->group(['prefix' => 'logs', 'as' => 'logs.'], function () use ($route) {
                    $route->get('/{type}/{id}/show', 'Integration\\Logs\\IntegrationLogsController@show')->name('show');
                });
            });

            $route->group(['middleware' => ['acl']], function() use ($route) {


                /**
                 * Products
                 */
                $route->group(['prefix' => 'products', 'as' => 'products.'], function () use ($route) {
                    $route->get('/', 'Product\\ProductController@index')->name('list');
                    $route->get('/create', 'Product\\ProductController@create')->name('create');
                    $route->post('/', 'Product\\ProductController@store')->name('create#store');
                    $route->get('/{product}/edit', 'Product\\ProductController@edit')->name('edit');
                    $route->delete('/{product}/delete', 'Product\\ProductController@destroy')->name('destroy');
                    $route->put('/{product}', 'Product\\ProductController@update')->name('edit#update');
                    $route->delete('/{product}/image/{image}/delete', 'Product\\ProductController@removeImage')->name('edit#remove-image');
                    $route->post('datatable', 'Product\\ProductController@datatable')->name('list#datatable');
                    $route->get('select', 'Product\\ProductController@getProductsSelect')->name('list#select');
                });

                /**
                 * Customers
                 */
                $route->group(['prefix' => 'customers', 'as' => 'customers.'], function () use ($route) {
                    $route->get('/', 'Customer\\CustomerController@index')->name('list');
                    $route->get('/create', 'Customer\\CustomerController@create')->name('create');
                    $route->post('/', 'Customer\\CustomerController@store')->name('create#store');
                    $route->get('/{customer}/edit', 'Customer\\CustomerController@edit')->name('edit');
                    $route->delete('/{customer}/delete', 'Customer\\CustomerController@destroy')->name('destroy');
                    $route->put('/{customer}', 'Customer\\CustomerController@update')->name('edit#update');
                    $route->post('datatable', 'Customer\\CustomerController@datatable')->name('list#datatable');
                    $route->get('/{customer}', 'Customer\\CustomerController@show')->name('show');
                    $route->post('/{customer}/export-erp', 'Customer\\CustomerController@exportToErp')->name('edit#export-erp');
                    $route->post('/{customer}/export-erp-queue', 'Customer\\CustomerController@exportToErpQueued')->name('edit#export-erp-queue');
                });

                /**
                 * Orders
                 */
                $route->group(['prefix' => 'orders', 'as' => 'orders.'], function () use ($route) {
                    $route->get('/', 'Order\\OrderController@index')->name('list');
                    $route->post('datatable', 'Order\\OrderController@datatable')->name('list#datatable');
                    $route->get('/{order}', 'Order\\OrderController@show')->name('show');
                    $route->get('/{order}/edit', 'Order\\OrderController@edit')->name('edit');
                    $route->put('/{order}/change-status', 'Order\\OrderController@changeStatus')->name('edit#change-status');
                    $route->get('/tracking-status/load-mail-template', 'Order\\OrderController@loadMailTemplate')->name('edit#load-mail-template');
                });

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
                    $route->post('datatable', 'Country\\CountryController@datatable')->name('list#datatable');
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
                    $route->post('datatable', 'Region\\RegionController@datatable')->name('list#datatable');
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
                    $route->post('datatable', 'Producer\\ProducerController@datatable')->name('list#datatable');
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
                    $route->post('datatable', 'Grape\\GrapeController@datatable')->name('list#datatable');
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
                    $route->post('datatable', 'ProductType\\ProductTypeController@datatable')->name('list#datatable');
                });

                /**
                 * Dollar
                 */
                $route->group(['prefix' => 'dollar', 'as' => 'dollar.'], function () use ($route) {
                    $route->get('/', 'Dollar\\DollarController@index')->name('list');
                    $route->get('/create', 'Dollar\\DollarController@create')->name('create');
                    $route->post('/', 'Dollar\\DollarController@store')->name('create#store');
                    $route->post('datatable', 'Dollar\\DollarController@datatable')->name('list#datatable');
                });

                /**
                 * Grapes
                 */
                $route->group(['prefix' => 'delivery-tracks', 'as' => 'delivery-tracks.'], function () use ($route) {
                    $route->get('/', 'DeliveryTrack\\DeliveryTrackController@index')->name('list');
                    $route->get('/create', 'DeliveryTrack\\DeliveryTrackController@create')->name('create');
                    $route->post('/', 'DeliveryTrack\\DeliveryTrackController@store')->name('create#store');
                    $route->get('/{grape}/edit', 'DeliveryTrack\\DeliveryTrackController@edit')->name('edit');
                    $route->delete('/{grape}/delete', 'DeliveryTrack\\DeliveryTrackController@destroy')->name('destroy');
                    $route->put('/{grape}', 'DeliveryTrack\\DeliveryTrackController@update')->name('edit#update');
                    $route->post('datatable', 'DeliveryTrack\\DeliveryTrackController@datatable')->name('list#datatable');
                });

                /**
                 * Deadline
                 */
                $route->group(['prefix' => 'deadline', 'as' => 'deadline.'], function () use ($route) {
                    $route->get('/', 'Deadline\\DeadlineController@index')->name('list');
                    $route->get('/create', 'Deadline\\DeadlineController@create')->name('create');
                    $route->post('/', 'Deadline\\DeadlineController@store')->name('create#store');
                    $route->post('datatable', 'Deadline\\DeadlineController@datatable')->name('list#datatable');
                });

                /**
                 * Newsletter
                 */
                $route->group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () use ($route) {
                    $route->get('/', 'Newsletter\\NewsletterController@index')->name('list');
                    $route->post('datatable', 'Newsletter\\NewsletterController@datatable')->name('list#datatable');
                    $route->get('export', 'Newsletter\\NewsletterController@export')->name('export');
                });

                /**
                 * Promotions
                 */
                $route->group(['prefix' => 'promotions', 'namespace' => 'Promotion'], function () use ($route) {

                    $route->post('{promotion}/items/add', 'PromotionController@addProducts');
                    $route->post('{promotion}/items/add-all', 'PromotionController@addAllProducts');
                    $route->post('{promotion}/items/add-from-filters', 'PromotionController@addProductsFromFilters');
                    $route->post('{promotion}/items/add-from-file', 'PromotionController@addProductsFromFile');
                    $route->delete('/{promotion}/remove-seal', 'PromotionController@removeSeal')->name('promotions.edit#remove-seal');

                    /**
                     * Discount promotion
                     */
                    $route->group(['prefix' => 'discount-promotion', 'as' => 'discount-promotion.'], function () use ($route) {
                        $route->get('/', 'DiscountPromotion\\DiscountPromotionController@index')->name('list');
                        $route->get('/create', 'DiscountPromotion\\DiscountPromotionController@create')->name('create');
                        $route->post('/', 'DiscountPromotion\\DiscountPromotionController@store')->name('create#store');
                        $route->get('/{promotion}/edit', 'DiscountPromotion\\DiscountPromotionController@edit')->name('edit');
                        $route->delete('/{promotion}/delete', 'DiscountPromotion\\DiscountPromotionController@destroy')->name('destroy');
                        $route->put('/{promotion}', 'DiscountPromotion\\DiscountPromotionController@update')->name('edit#update');
                        $route->delete('/{promotion}/photo/{photo}/delete', 'DiscountPromotion\\DiscountPromotionController@removeImage')->name('edit#remove-image');
                        $route->post('datatable', 'DiscountPromotion\\DiscountPromotionController@datatable')->name('list#datatable');
                        $route->post('/{promotion}/items/datatable', 'DiscountPromotion\\DiscountPromotionController@itemsDatatable')->name('edit#items-datatable');
                        $route->delete('/{promotion}/items/{item}/delete', 'DiscountPromotion\\DiscountPromotionController@removeItem')->name('edit#remove-item');
                    });

                    /**
                     * Shipping promotion
                     */
                    $route->group(['prefix' => 'shipping-promotion', 'as' => 'shipping-promotion.'], function () use ($route) {
                        $route->get('/', 'ShippingPromotion\\ShippingPromotionController@index')->name('list');
                        $route->get('/create', 'ShippingPromotion\\ShippingPromotionController@create')->name('create');
                        $route->post('/', 'ShippingPromotion\\ShippingPromotionController@store')->name('create#store');
                        $route->get('/{promotion}/edit', 'ShippingPromotion\\ShippingPromotionController@edit')->name('edit');
                        $route->delete('/{promotion}/delete', 'ShippingPromotion\\ShippingPromotionController@destroy')->name('destroy');
                        $route->put('/{promotion}', 'ShippingPromotion\\ShippingPromotionController@update')->name('edit#update');
                        $route->post('datatable', 'ShippingPromotion\\ShippingPromotionController@datatable')->name('list#datatable');
                    });

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
                        $route->post('datatable', 'Highlight\\HighlightController@datatable')->name('list#datatable');
                    });

                    /**
                     * Home banners
                     */
                    $route->group(['prefix' => 'home-banners', 'as' => 'home-banners.'], function () use ($route) {
                        $route->get('/', 'Highlight\\HighlightController@index')->name('list');
                        $route->get('/create', 'Highlight\\HighlightController@create')->name('create');
                        $route->post('/', 'Highlight\\HighlightController@store')->name('create#store');
                        $route->get('/{highlight}/edit', 'Highlight\\HighlightController@edit')->name('edit');
                        $route->delete('/{highlight}/delete', 'Highlight\\HighlightController@destroy')->name('destroy');
                        $route->put('/{highlight}', 'Highlight\\HighlightController@update')->name('edit#update');
                        $route->delete('/{highlight}/photo/{photo}/delete', 'Highlight\\HighlightController@removeImage')->name('edit#remove-image');
                        $route->post('datatable', 'Highlight\\HighlightController@datatable')->name('list#datatable');
                    });

                });

                /**
                 * Showcases
                 */
                $route->group(['prefix' => 'showcases'], function () use ($route) {

                    /**
                     * Default showcases
                     */
                    $route->group(['prefix' => 'default-showcases', 'as' => 'default-showcases.'], function () use ($route) {
                        $route->get('/', 'Showcase\\ShowcaseController@index')->name('list');
                        $route->get('/create', 'Showcase\\ShowcaseController@create')->name('create');
                        $route->post('/', 'Showcase\\ShowcaseController@store')->name('create#store');
                        $route->get('/{showcase}/edit', 'Showcase\\ShowcaseController@edit')->name('edit');
                        $route->delete('/{showcase}/delete', 'Showcase\\ShowcaseController@destroy')->name('destroy');
                        $route->put('/{showcase}', 'Showcase\\ShowcaseController@update')->name('edit#update');
                        $route->delete('/{showcase}/photo/{photo}/delete', 'Showcase\\ShowcaseController@removeImage')->name('edit#remove-image');
                        $route->post('datatable', 'Showcase\\ShowcaseController@datatable')->name('list#datatable');
                        $route->post('/{showcase}/items/datatable', 'Showcase\\ShowcaseController@itemsDatatable')->name('edit#items-datatable');
                        $route->delete('/{showcase}/items/{item}/delete', 'Showcase\\ShowcaseController@removeItem')->name('edit#remove-item');
                        $route->post('/{showcase}/items', 'Showcase\\ShowcaseController@addItem')->name('edit#add-item');
                    });

                    /**
                     * Home showcases
                     */
                    $route->group(['prefix' => 'home-showcases', 'as' => 'home-showcases.'], function () use ($route) {
                        $route->get('/', 'Showcase\\ShowcaseController@index')->name('list');
                        $route->get('/create', 'Showcase\\ShowcaseController@create')->name('create');
                        $route->post('/', 'Showcase\\ShowcaseController@store')->name('create#store');
                        $route->get('/{showcase}/edit', 'Showcase\\ShowcaseController@edit')->name('edit');
                        $route->delete('/{showcase}/delete', 'Showcase\\ShowcaseController@destroy')->name('destroy');
                        $route->put('/{showcase}', 'Showcase\\ShowcaseController@update')->name('edit#update');
                        $route->delete('/{showcase}/photo/{photo}/delete', 'Showcase\\ShowcaseController@removeImage')->name('edit#remove-image');
                        $route->post('datatable', 'Showcase\\ShowcaseController@datatable')->name('list#datatable');
                        $route->post('/{showcase}/items/datatable', 'Showcase\\ShowcaseController@itemsDatatable')->name('edit#items-datatable');
                        $route->delete('/{showcase}/items/{item}/delete', 'Showcase\\ShowcaseController@removeItem')->name('edit#remove-item');
                        $route->post('/{showcase}/items', 'Showcase\\ShowcaseController@addItem')->name('edit#add-item');
                    });

                    /**
                     * Week highlights showcases
                     */
                    $route->group(['prefix' => 'week-highlights-showcases', 'as' => 'week-highlights-showcases.'], function () use ($route) {
                        $route->get('/', 'Showcase\\ShowcaseController@index')->name('list');
                        $route->get('/create', 'Showcase\\ShowcaseController@create')->name('create');
                        $route->post('/', 'Showcase\\ShowcaseController@store')->name('create#store');
                        $route->get('/{showcase}/edit', 'Showcase\\ShowcaseController@edit')->name('edit');
                        $route->delete('/{showcase}/delete', 'Showcase\\ShowcaseController@destroy')->name('destroy');
                        $route->put('/{showcase}', 'Showcase\\ShowcaseController@update')->name('edit#update');
                        $route->delete('/{showcase}/photo/{photo}/delete', 'Showcase\\ShowcaseController@removeImage')->name('edit#remove-image');
                        $route->post('datatable', 'Showcase\\ShowcaseController@datatable')->name('list#datatable');
                        $route->post('/{showcase}/items/datatable', 'Showcase\\ShowcaseController@itemsDatatable')->name('edit#items-datatable');
                        $route->delete('/{showcase}/items/{item}/delete', 'Showcase\\ShowcaseController@removeItem')->name('edit#remove-item');
                        $route->post('/{showcase}/items', 'Showcase\\ShowcaseController@addItem')->name('edit#add-item');
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
                    $route->post('datatable', 'User\\UserController@datatable')->name('list#datatable');
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
                    $route->post('datatable', 'Role\\RoleController@datatable')->name('list#datatable');
                });

                $route->group(['prefix' => 'minha-conta', 'as' => 'account.'], function () use ($route) {
                    $route->get('/', 'Account\\AccountController@index')->name('index');
                    $route->get('/editar', 'Account\\AccountController@edit')->name('edit');
                });

            });

            $route->group(['prefix' => 'api', 'as' => 'api.'], function() use ($route) {

                $route->group(['prefix' => 'showcase', 'as' => 'showcase.'], function() use ($route) {
                    $route->post('{showcase}/items/{item}/update-position', 'Showcase\ShowcaseController@updateItemPosition')->name('update-position');
                });

            });

        });

        $route->group(['prefix' => 'tests', 'as' => 'test.', 'namespace' => 'Tests'], function() use ($route) {

            $route->get('order-mail-template/{namespace}/{name}/{order}', 'OrderMailTemplateController@render');
            $route->get('customer-mail-template/{namespace}/{name}/{customer}', 'CustomerMailTemplateController@render');

        });

    });

});