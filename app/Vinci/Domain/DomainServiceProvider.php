<?php

namespace Vinci\Domain;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Customer\CustomerService;

class DomainServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->singleton(CustomerService::class, function($app) {
            return new CustomerService(
                $app[CustomerRepository::class],
                $app['em']
            );
        });

    }
}