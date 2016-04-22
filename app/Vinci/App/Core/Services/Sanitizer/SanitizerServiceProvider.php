<?php

namespace Vinci\App\Core\Services\Sanitizer;

use Illuminate\Support\ServiceProvider;

class SanitizerServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app['sanitizer'] = $this->app->share(function ($app) {
            return new Sanitizer($this->app);
        });
    }

}