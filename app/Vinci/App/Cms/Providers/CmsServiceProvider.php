<?php

namespace Vinci\App\Cms\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    protected $namespace = 'Vinci\\App\\Cms\Http';

    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
    }

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'prefix' => 'cms', 'as' => 'cms.'], function ($route) {
            require __DIR__ . '/../Http/routes.php';
        });
    }
}