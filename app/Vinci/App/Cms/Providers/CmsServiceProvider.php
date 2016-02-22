<?php

namespace Vinci\App\Cms\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    protected $namespace = 'Vinci\\App\\Cms\Http';

    public function register()
    {
        $this->registerRoutes($this->app['router']);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
    }

    protected function registerRoutes(Router $router)
    {
        $config = [
            'namespace' => $this->namespace,
            'prefix'    => 'cms'
        ];

        $router->group($config, function($route) {
            require __DIR__ . '/../Http/routes.php';
        });
    }
}