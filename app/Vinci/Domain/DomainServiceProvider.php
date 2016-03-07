<?php

namespace Vinci\Domain;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\User\Admin\AdminRepository;
use Vinci\Domain\User\Admin\AdminService;
use Vinci\Domain\User\Customer\CustomerRepository;
use Vinci\Domain\User\Customer\CustomerService;

class DomainServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->singleton(CustomerService::class, function($app) {
            return new CustomerService(
                $app[CustomerRepository::class],
                $app['db']->getDefaultConnection()
            );
        });

        $this->app->singleton(AdminService::class, function($app) {
            return new AdminService(
                $app[AdminRepository::class],
                $app['db']->getDefaultConnection()
            );
        });

    }
}