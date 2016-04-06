<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;

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
            'Vinci\Domain\ACL\Module\ModuleRepository',
            'Vinci\Infrastructure\ACL\Modules\DoctrineModuleRepository',
            'Vinci\Domain\ACL\Module\Module'
        );

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