<?php

namespace Vinci\Domain;

use Illuminate\Support\ServiceProvider;
use Vinci\App\Website\Channel\ChannelProvider;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Admin\AdminService;
use Vinci\Domain\Customer\Address\AddressService;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\DeliveryTrack\DeliveryTrackService;
use Vinci\Domain\Highlight\HighlightService;
use Vinci\Domain\Country\CountryService;
use Vinci\Domain\Pricing\Calculator\PriceCalculatorProvider;
use Vinci\Domain\Pricing\Calculator\StandardPriceCalculator;
use Vinci\Domain\Region\RegionService;
use Vinci\Domain\Producer\ProducerService;
use Vinci\Domain\Grape\GrapeService;
use Vinci\Domain\ProductType\ProductTypeService;

class DomainServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->singleton('Vinci\Domain\ACL\ACLService', function() {
            return new ACLService(
                $this->app['em'],
                $this->app->make('Vinci\Domain\ACL\Module\ModuleRepository'),
                $this->app->make('Vinci\Domain\ACL\Role\RoleRepository'),
                $this->app->make('Vinci\Domain\ACL\Permission\PermissionRepository')
            );
        });

        $this->app->singleton('Vinci\Domain\Customer\Address\AddressService', function() {
            return new AddressService(
                $this->app['em'],
                $this->app['Vinci\Domain\Customer\Address\AddressFactory'],
                $this->app['Vinci\Domain\Address\MultiAddressValidator'],
                $this->app['sanitizer']
            );
        });

        $this->app->singleton('Vinci\Domain\Customer\CustomerService', function() {
            return new CustomerService(
                $this->app['em'],
                $this->app['Vinci\Domain\Customer\CustomerRepository'],
                $this->app->make('Vinci\Domain\Customer\CustomerValidator'),
                $this->app->make('Vinci\Domain\Customer\Address\AddressService'),
                $this->app['sanitizer']
            );
        });

        $this->app->singleton('Vinci\Domain\DeliveryTrack\DeliveryTrackService', function() {
            return new DeliveryTrackService(
                $this->app['em'],
                $this->app['Vinci\Domain\DeliveryTrack\DeliveryTrackRepository'],
                $this->app->make('Vinci\Domain\DeliveryTrack\DeliveryTrackValidator'),
                $this->app->make('Vinci\Domain\DeliveryTrack\LineValidator'),
                $this->app['sanitizer']
            );
        });

        $this->app->singleton('Vinci\Domain\Admin\AdminService', function() {
            return new AdminService(
                $this->app['Vinci\Domain\Admin\AdminRepository'],
                $this->app['em'],
                $this->app->make('Vinci\Domain\Admin\AdminValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository']
            );
        });

        $this->app->singleton('Vinci\Domain\Highlight\HighlightService', function() {
            return new HighlightService(
                $this->app['em'],
                $this->app['Vinci\Domain\Highlight\HighlightRepository'],
                $this->app->make('Vinci\Domain\Highlight\HighlightValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository'],
                $this->app['Vinci\Domain\ACL\ACLService']
            );
        });

        $this->app->singleton('Vinci\Domain\Country\CountryService', function() {
            return new CountryService(
                $this->app['em'],
                $this->app['Vinci\Domain\Country\CountryRepository'],
                $this->app->make('Vinci\Domain\Country\CountryValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository']
            );
        });

        $this->app->singleton('Vinci\Domain\Region\RegionService', function() {
            return new RegionService(
                $this->app['em'],
                $this->app['Vinci\Domain\Region\RegionRepository'],
                $this->app->make('Vinci\Domain\Region\RegionValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository']
            );
        });

        $this->app->singleton('Vinci\Domain\Producer\ProducerService', function() {
            return new ProducerService(
                $this->app['em'],
                $this->app['Vinci\Domain\Producer\ProducerRepository'],
                $this->app->make('Vinci\Domain\Producer\ProducerValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository']
            );
        });

        $this->app->singleton('Vinci\Domain\Grape\GrapeService', function() {
            return new GrapeService(
                $this->app['em'],
                $this->app['Vinci\Domain\Grape\GrapeRepository'],
                $this->app->make('Vinci\Domain\Grape\GrapeValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository']
            );
        });

        $this->app->singleton('Vinci\Domain\ProductType\ProductTypeService', function() {
            return new ProductTypeService(
                $this->app['em'],
                $this->app['Vinci\Domain\ProductType\ProductTypeRepository'],
                $this->app->make('Vinci\Domain\ProductType\ProductTypeValidator'),
                $this->app['Vinci\Infrastructure\Storage\StorageService'],
                $this->app['Vinci\Domain\Image\ImageRepository']
            );
        });

        $this->app->singleton('Vinci\Domain\Product\Factories\Contracts\ProductFactory', function() {
            return $this->app->make('Vinci\Domain\Product\Factories\ProductFactory');
        });

        $this->app->singleton('Vinci\Domain\Channel\Contracts\ChannelProvider', function() {
            return new ChannelProvider;
        });

        $this->app->singleton('Vinci\Domain\Pricing\PriceCalculator', function() {
            return new StandardPriceCalculator();
        });

        $this->app->singleton('Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider', function() {
            return new PriceCalculatorProvider($this->app['Vinci\Domain\Pricing\PriceCalculator']);
        });

    }
}