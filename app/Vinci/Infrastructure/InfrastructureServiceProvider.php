<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Order\Order;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\User\User;
use Vinci\Domain\User\UserRepository;
use Vinci\Infrastructure\Admin\DoctrineAdminRepository;
use Vinci\Infrastructure\Customers\DoctrineCustomerRepository;
use Vinci\Infrastructure\Orders\DoctrineOrderRepository;
use Vinci\Infrastructure\Users\DoctrineUserRepository;

class InfrastructureServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(UserRepository::class, function($app) {
           return new DoctrineUserRepository(
               $app['em'],
               $app['em']->getClassMetaData(User::class)
           );
        });

        $this->app->singleton(CustomerRepository::class, function($app) {
            return new DoctrineCustomerRepository(
                $app['em'],
                $app['em']->getClassMetaData(Customer::class)
            );
        });

        $this->app->singleton(AdminRepository::class, function($app) {
            return new DoctrineAdminRepository(
                $app['em'],
                $app['em']->getClassMetaData(Customer::class)
            );
        });

        $this->app->singleton(OrderRepository::class, function($app) {
            return new DoctrineOrderRepository(
                $app['em'],
                $app['em']->getClassMetaData(Order::class)
            );
        });

    }

}