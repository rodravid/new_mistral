<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Vinci\Infrastructure\ACL\Modules\DoctrineModuleRepository;
use Vinci\Infrastructure\ACL\Modules\DoctrineModuleRepositoryCached;
use Vinci\Infrastructure\Storage\StorageService;

class InfrastructureServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->registerRepository(
            'Vinci\Domain\User\UserRepository',
            'Vinci\Infrastructure\User\DoctrineUserRepository',
            'Vinci\Domain\User\User'
        );

        $this->registerRepository(
            'Vinci\Domain\Customer\CustomerRepository',
            'Vinci\Infrastructure\Customers\DoctrineCustomerRepository',
            'Vinci\Domain\Customer\Customer'
        );

        $this->registerRepository(
            'Vinci\Domain\Order\OrderRepository',
            'Vinci\Infrastructure\Orders\DoctrineOrderRepository',
            'Vinci\Domain\Order\Order'
        );

        $this->registerRepository(
            'Vinci\Domain\Admin\AdminRepository',
            'Vinci\Infrastructure\Admin\DoctrineAdminRepository',
            'Vinci\Domain\Admin\Admin'
        );

        $this->registerRepository(
            'Vinci\Domain\ACL\Role\RoleRepository',
            'Vinci\Infrastructure\ACL\Roles\DoctrineRoleRepository',
            'Vinci\Domain\ACL\Role\Role'
        );

        $this->registerRepository(
            'Vinci\Domain\ACL\Permission\PermissionRepository',
            'Vinci\Infrastructure\ACL\Permissions\DoctrinePermissionRepositoryCached',
            'Vinci\Domain\ACL\Permission\Permission'
        );

        $this->registerRepository(
            'Vinci\Domain\ACL\Module\ModuleRepository',
            'Vinci\Infrastructure\ACL\Modules\DoctrineModuleRepositoryCached',
            'Vinci\Domain\ACL\Module\Module'
        );

        $this->registerRepository(
            'Vinci\Domain\Newsletter',
            'Vinci\Infrastructure\Newsletter\DoctrineNewsletterRepository',
            'Vinci\Domain\Newsletter\Newsletter'
        );

        $this->app->singleton('Vinci\Infrastructure\Storage\StorageService', function() {
            return new StorageService($this->app['filesystem'], $this->app['config']);
        });

    }

    protected function registerRepository($repositoryInterfaceClass, $concreteRepository, $entityClass)
    {
        $this->app->singleton($repositoryInterfaceClass, function($app) use ($concreteRepository, $entityClass) {
            $entityManager = $app['em'];

            return new $concreteRepository(
                $entityManager,
                $entityManager->getClassMetaData($entityClass)
            );
        });
    }

}