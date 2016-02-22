<?php

namespace Vinci\App\Website\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class WebsiteServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerRoutes($this->app['router']);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'site');
    }

    protected function registerRoutes(Router $router)
    {
        $router->group(['namespace' => 'Vinci\\App\\Website\Http\\Controllers'], function($route) {
            require __DIR__ . '/../Http/routes.php';
        });
    }
}