<?php

namespace Vinci\Domain;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Admin\AdminService;
use Vinci\Domain\Admin\AdminValidator;
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

        $this->app->singleton('Vinci\Domain\ACL\ACLService', function() {
            return new ACLService(
                $this->app['em'],
                $this->app->make('Vinci\Domain\ACL\Module\ModuleRepository'),
                $this->app->make('Vinci\Domain\ACL\Permission\PermissionRepository')
            );
        });

        $this->app->singleton('Vinci\Domain\Admin\AdminService', function() {
            return new AdminService(
                $this->app['Vinci\Domain\Admin\AdminRepository'],
                $this->app['em'],
                new AdminValidator($this->app['validator']),
                $this->app['Vinci\Infrastructure\Storage\StorageService']
            );
        });

    }
}