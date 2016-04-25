<?php

namespace Vinci\App\Api\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class ApiServiceProvider extends ServiceProvider
{
    protected $namespace = 'Vinci\\App\\Api\\Http';

    public function register()
    {

    }

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'prefix' => 'api', 'as' => 'api.'], function ($route) {
            require __DIR__ . '/../Http/routes.php';
        });
    }
}