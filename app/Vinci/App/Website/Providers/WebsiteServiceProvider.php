<?php

namespace Vinci\App\Website\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class WebsiteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Vinci\\App\\Website\Http';

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
}