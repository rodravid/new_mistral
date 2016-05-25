<?php

namespace Vinci\Infrastructure;

use Illuminate\Support\ServiceProvider;
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
            'Vinci\Infrastructure\Customer\DoctrineCustomerRepository',
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
            'Vinci\Domain\Image\ImageRepository',
            'Vinci\Infrastructure\Image\DoctrineImageRepository',
            'Vinci\Domain\Image\Image'
        );

        $this->registerRepository(
            'Vinci\Domain\Newsletter\NewsletterRepository',
            'Vinci\Infrastructure\Newsletter\DoctrineNewsletterRepository',
            'Vinci\Domain\Newsletter\Newsletter'
        );

        $this->registerRepository(
            'Vinci\Domain\Dollar\DollarRepository',
            'Vinci\Infrastructure\Dollar\DoctrineDollarRepository',
            'Vinci\Domain\Dollar\Dollar'
        );

        $this->registerRepository(
            'Vinci\Domain\Deadline\DeadlineRepository',
            'Vinci\Infrastructure\Deadline\DoctrineDeadlineRepository',
            'Vinci\Domain\Deadline\Deadline'
        );

        $this->registerRepository(
            'Vinci\Domain\DeliveryTrack\DeliveryTrackRepository',
            'Vinci\Infrastructure\DeliveryTrack\DoctrineDeliveryTrackRepository',
            'Vinci\Domain\DeliveryTrack\DeliveryTrack'
        );

        $this->registerRepository(
            'Vinci\Domain\Highlight\HighlightRepository',
            'Vinci\Infrastructure\Highlight\DoctrineHighlightRepository',
            'Vinci\Domain\Highlight\Highlight'
        );

        $this->registerRepository(
            'Vinci\Domain\Country\CountryRepository',
            'Vinci\Infrastructure\Country\DoctrineCountryRepository',
            'Vinci\Domain\Country\Country'
        );

        $this->registerRepository(
            'Vinci\Domain\Region\RegionRepository',
            'Vinci\Infrastructure\Region\DoctrineRegionRepository',
            'Vinci\Domain\Region\Region'
        );

        $this->registerRepository(
            'Vinci\Domain\Producer\ProducerRepository',
            'Vinci\Infrastructure\Producer\DoctrineProducerRepository',
            'Vinci\Domain\Producer\Producer'
        );

        $this->registerRepository(
            'Vinci\Domain\Grape\GrapeRepository',
            'Vinci\Infrastructure\Grape\DoctrineGrapeRepository',
            'Vinci\Domain\Grape\Grape'
        );

        $this->registerRepository(
            'Vinci\Domain\ProductType\ProductTypeRepository',
            'Vinci\Infrastructure\ProductType\DoctrineProductTypeRepository',
            'Vinci\Domain\ProductType\ProductType'
        );

        $this->registerRepository(
            'Vinci\Domain\Address\Country\CountryRepository',
            'Vinci\Infrastructure\Address\Country\DoctrineCountryRepository',
            'Vinci\Domain\Address\Country\Country'
        );

        $this->registerRepository(
            'Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository',
            'Vinci\Infrastructure\ShoppingCart\DoctrineShoppingCartRepository',
            'Vinci\Domain\ShoppingCart\ShoppingCart'
        );

        $this->app->alias('Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository', 'cart.repository');

//        $this->registerRepository(
//            'Vinci\Domain\Address\State\StateRepository',
//            'Vinci\Infrastructure\Address\State\DoctrineStateRepository',
//            'Vinci\Domain\Address\State\State'
//        );
//
//        $this->registerRepository(
//            'Vinci\Domain\Address\City\CityRepository',
//            'Vinci\Infrastructure\Address\City\DoctrineCityRepository',
//            'Vinci\Domain\Address\City\City'
//        );

        $this->registerRepository(
            'Vinci\Domain\Product\Repositories\ProductRepository',
            'Vinci\Infrastructure\Product\DoctrineProductRepository',
            'Vinci\Domain\Product\Product'
        );

        $this->registerRepository(
            'Vinci\Domain\Product\Repositories\ProductVariantRepository',
            'Vinci\Infrastructure\Product\Variant\DoctrineProductVariantRepository',
            'Vinci\Domain\Product\ProductVariant'
        );

        $this->registerRepository(
            'Vinci\Domain\Channel\ChannelRepository',
            'Vinci\Infrastructure\Channel\DoctrineChannelRepository',
            'Vinci\Domain\Channel\Channel'
        );

        $this->registerRepository(
            'Vinci\Domain\Customer\Address\AddressRepository',
            'Vinci\Infrastructure\Customer\Address\DoctrineAddressRepository',
            'Vinci\Domain\Customer\Address\Address'
        );

        $this->app->singleton('Vinci\Domain\Address\City\CityRepository', function() {

            $stateRepository =  $this->app->make('Vinci\Infrastructure\Address\City\DoctrineCityRepository', [
                $this->app['em'],
                $this->app['em']->getClassMetaData('Vinci\Domain\Address\City\City')
            ]);

            return $this->app->make('Vinci\Infrastructure\Address\City\DoctrineCityRepositoryCached', [
                $stateRepository,
                $this->app['cache']->driver()
            ]);

        });

        $this->app->singleton('Vinci\Domain\Address\State\StateRepository', function() {

            $stateRepository =  $this->app->make('Vinci\Infrastructure\Address\State\DoctrineStateRepository', [
                $this->app['em'],
                $this->app['em']->getClassMetaData('Vinci\Domain\Address\State\State')
            ]);

            return $this->app->make('Vinci\Infrastructure\Address\State\DoctrineStateRepositoryCached', [
                $stateRepository,
                $this->app['cache']->driver()
            ]);

        });

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