<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\User\UserRepository;
use Vinci\Infrastructure\Users\EloquentUserRepository;

class InfrastructureServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->singleton(UserRepository::class, function() {
           return new EloquentUserRepository;
        });

    }

}