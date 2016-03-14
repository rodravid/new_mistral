<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\Admin\Admin\AdminRepository;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\User\UserRepository;
use Vinci\Infrastructure\Customers\DoctrineCustomerRepository;
use Vinci\Infrastructure\Users\EloquentUserRepository;

class InfrastructureServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(UserRepository::class, function($app) {
           return new EloquentUserRepository($app);
        });

        $this->app->singleton(CustomerRepository::class, function($app) {
            return new DoctrineCustomerRepository(
                $app['em'],
                $app['em']->getClassMetaData(Customer::class)
            );
        });

        $this->app->singleton(AdminRepository::class, function($app) {
            return new DoctrineCustomerRepository(
                $app['em'],
                $app['em']->getClassMetaData(Customer::class)
            );
        });
    }

}