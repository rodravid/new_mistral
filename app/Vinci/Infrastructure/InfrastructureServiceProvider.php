<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\User\Admin\AdminRepository;
use Vinci\Domain\User\Customer\CustomerRepository;
use Vinci\Domain\User\UserRepository;
use Vinci\Infrastructure\Users\EloquentAdminRepository;
use Vinci\Infrastructure\Users\EloquentCustomerRepository;
use Vinci\Infrastructure\Users\EloquentUserRepository;

class InfrastructureServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(UserRepository::class, function($app) {
           return new EloquentUserRepository($app);
        });

        $this->app->singleton(CustomerRepository::class, function($app) {
            return new EloquentCustomerRepository($app);
        });

        $this->app->singleton(AdminRepository::class, function($app) {
            return new EloquentAdminRepository($app);
        });
    }

}