<?php

namespace Vinci\App\Website\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class WebsiteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Vinci\\App\\Website\Http';

    public function boot(Router $router)
    {
        parent::boot($router);

        $this->registerComposers();
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'website');
    }

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($route) {
            require __DIR__ . '/../Http/routes.php';
        });
    }

    protected function registerComposers()
    {
        $this->app['view']->composer('website::layouts.modals.address.default', 'Vinci\App\Website\Http\ViewComposers\ModalAddressComposer');
    }
}