<?php

namespace Vinci\App\Core\Services\Sanitizer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SanitizerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['sanitizer']->register('strtolower', function ($field) {
            return Str::lower($field);
        });

        $this->app['sanitizer']->register('strtoupper', function ($field) {
            return Str::upper($field);
        });

    }

    public function register()
    {
        $this->app['sanitizer'] = $this->app->share(function ($app) {
            return new Sanitizer($this->app);
        });
    }

}