<?php

namespace Vinci\Domain;

use Illuminate\Support\ServiceProvider;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Auth\Events\Listeners\LinkCustomerToCurrentCart;
use Vinci\App\Website\Channel\ChannelProvider;
use Vinci\App\Website\Http\ShoppingCart\Provider\CustomerShoppingCartProvider;
use Vinci\App\Website\Http\ShoppingCart\Provider\ShoppingCartProvider;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Admin\AdminService;
use Vinci\Domain\Customer\Address\AddressService;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\DeliveryTrack\DeliveryTrackService;
use Vinci\Domain\Dollar\Providers\DefaultDollarProvider;
use Vinci\Domain\Highlight\HighlightService;
use Vinci\Domain\Country\CountryService;
use Vinci\Domain\Inventory\Checkers\AvailabilityChecker;
use Vinci\Domain\Pricing\Calculator\PriceCalculatorProvider;
use Vinci\Domain\Pricing\Calculator\StandardPriceCalculator;
use Vinci\Domain\Product\Services\ProductUrlGenerator;
use Vinci\Domain\ProductNotify\Services\ProductNotifyService;
use Vinci\Domain\Promotion\Types\Discount\Providers\DefaultDiscountPromotionProvider;
use Vinci\Domain\Promotion\Types\Shipping\DefaultShippingPromotionLocator;
use Vinci\Domain\Recomendations\Products\Service\DefaultProductRecommendedService;
use Vinci\Domain\Region\RegionService;
use Vinci\Domain\Producer\ProducerService;
use Vinci\Domain\Grape\GrapeService;
use Vinci\Domain\ProductType\ProductTypeService;
use Vinci\Domain\Shipping\Services\ShippingCarrierLocator;
use Vinci\Domain\ShoppingCart\Factory\ShoppingCartItemFactory;
use Vinci\Domain\ShoppingCart\Resolver\ItemResolver;
use Vinci\Domain\Showcase\StaticShowcases\DefaultStaticShowcasesProvider;

class DomainServiceProvider extends ServiceProvider
{

    protected $defer = true;

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
                $this->app['address.repository'],
                $this->app['sanitizer']
            );
        });

        $this->app->singleton('Vinci\Domain\Customer\CustomerService', function() {
            return new CustomerService(
                $this->app['em'],
                $this->app['Vinci\Domain\Customer\CustomerRepository'],
                $this->app->make('Vinci\Domain\Customer\CustomerValidator'),
                $this->app->make('Vinci\Domain\Customer\Address\AddressService'),
                $this->app['sanitizer'],
                $this->app['events']
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

        $this->app->singleton('Vinci\Domain\ProductNotify\Services\ProductNotifyService', function() {
            return new ProductNotifyService(
                $this->app['Vinci\Domain\ProductNotify\Repositories\ProductNotifyRepository'],
                $this->app->make('Vinci\Domain\ProductNotify\Validators\ProductNotifyValidator'),
                $this->app->make('Vinci\Domain\Product\Repositories\ProductRepository')
            );
        });

        $this->app->singleton('Vinci\Domain\Shipping\Contracts\ShippingCarrierLocator', function() {
            return new ShippingCarrierLocator(
                $this->app['carrier.repository']
            );
        });

        $this->app->singleton('Vinci\Domain\Promotion\Types\Shipping\ShippingPromotionLocator', function() {
            return new DefaultShippingPromotionLocator(
                $this->app['shipping_promotion.repository']
            );
        });

        $this->app->singleton('Vinci\Domain\Product\Factories\Contracts\ProductFactory', function() {
            return $this->app->make('Vinci\Domain\Product\Factories\ProductFactory');
        });

        $this->app->singleton('product.url_generator', function() {
            return new ProductUrlGenerator;
        });

        $this->app->singleton('Vinci\Domain\Channel\Contracts\ChannelContext', function() {
            return $this->app->make('Vinci\App\Website\Channel\Context\ChannelContextSession', [$this->app['session']->driver()]);
        });

        $this->app->singleton('Vinci\Domain\Channel\Contracts\ChannelProvider', function() {

            $context = $this->app->make('Vinci\Domain\Channel\Contracts\ChannelContext');
            $repository = $this->app->make('Vinci\Domain\Channel\ChannelRepository');

            return new ChannelProvider($context, $repository);
        });

        $this->app->singleton('Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory', function() {
            return $this->app->make('Vinci\Domain\ShoppingCart\Factory\ShoppingCartFactory');
        });

        $this->app->singleton('Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext', function() {
            return $this->app->make('Vinci\App\Website\Http\ShoppingCart\Context\ShoppingCartContextSession', [$this->app['session']->driver()]);
        });

        $this->app->singleton('cart.provider', function() {

            $context = $this->app->make('Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext');
            $repository = $this->app->make('Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository');
            $factory = $this->app->make('Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory');

            return new ShoppingCartProvider($context, $repository, $factory, $this->app['auth']->guard('website'));
        });

        $this->app->singleton('Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider', function() {
            return new CustomerShoppingCartProvider(
                $this->app['cart.provider'],
                $this->app['cart.repository'],
                $this->app['auth']->guard('website')
            );
        });

        $this->app->singleton('Vinci\Domain\Inventory\Checkers\Contracts\AvailabilityChecker', function() {
            return new AvailabilityChecker;
        });

        $this->app->alias('Vinci\Domain\Inventory\Checkers\Contracts\AvailabilityChecker', 'inventory.checker');

        $this->app->singleton('Vinci\Domain\ShoppingCart\Resolver\Contracts\ItemResolver', function() {
            return new ItemResolver($this->app['inventory.checker'], new ShoppingCartItemFactory);
        });

        $this->app->singleton('Vinci\App\Website\Auth\Events\Listeners\LinkCustomerToCurrentCart', function() {

            $cartProvider = $this->app->make('cart.provider');
            $cartRepository = $this->app->make('Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository');

            return new LinkCustomerToCurrentCart($cartProvider, $cartRepository);
        });

        $this->app->singleton('Vinci\Domain\Dollar\DollarProvider', function() {
            return new DefaultDollarProvider($this->app['Vinci\Domain\Dollar\DollarRepository']);
        });

        $this->app->singleton('Vinci\Domain\Pricing\PriceCalculator', function() {
            return new StandardPriceCalculator($this->app['Vinci\Domain\Dollar\DollarProvider']);
        });

        $this->app->singleton('Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider', function($app) {
            return new PriceCalculatorProvider($app);
        });

        $this->app->alias('Vinci\Domain\Product\Services\FavoriteService', 'product.favorite.service');

        $this->app->singleton('Vinci\Domain\Promotion\Types\Discount\DiscountPromotionProvider', function($app) {

            $repository = $app['Vinci\Domain\Promotion\Types\Discount\DiscountPromotionRepository'];

            return new DefaultDiscountPromotionProvider($repository, $app['cache']->driver());
        });

        $this->app->singleton('Vinci\Domain\Recomendations\Products\Service\ProductRecommendedService', function ($app) {
            return new DefaultProductRecommendedService($app['product.repository'], $app[Presenter::class]);
        });
        
        $this->app->singleton('Vinci\Domain\Showcase\StaticShowcases\StaticShowcasesProvider', function() {
            return new DefaultStaticShowcasesProvider;
        });
        
        $this->app->alias('Vinci\Domain\Showcase\StaticShowcases\StaticShowcasesProvider', 'showcase.static.provider');

    }

    public function provides()
    {
        return [
            'Vinci\Domain\ACL\ACLService',
            'Vinci\Domain\Customer\Address\AddressService',
            'Vinci\Domain\Customer\CustomerService',
            'Vinci\Domain\DeliveryTrack\DeliveryTrackService',
            'Vinci\Domain\Admin\AdminService',
            'Vinci\Domain\Highlight\HighlightService',
            'Vinci\Domain\Country\CountryService',
            'Vinci\Domain\Region\RegionService',
            'Vinci\Domain\Producer\ProducerService',
            'Vinci\Domain\Grape\GrapeService',
            'Vinci\Domain\ProductType\ProductTypeService',
            'Vinci\Domain\ProductNotify\Services\ProductNotifyService',
            'Vinci\Domain\Shipping\Contracts\ShippingCarrierLocator',
            'Vinci\Domain\Promotion\Types\Shipping\ShippingPromotionLocator',
            'Vinci\Domain\Product\Factories\Contracts\ProductFactory',
            'product.url_generator',
            'Vinci\Domain\Channel\Contracts\ChannelContext',
            'Vinci\Domain\Channel\Contracts\ChannelProvider',
            'Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory',
            'Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext',
            'cart.provider',
            'Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider',
            'Vinci\Domain\Inventory\Checkers\Contracts\AvailabilityChecker',
            'Vinci\Domain\ShoppingCart\Resolver\Contracts\ItemResolver',
            'Vinci\App\Website\Auth\Events\Listeners\LinkCustomerToCurrentCart',
            'Vinci\Domain\Dollar\DollarProvider',
            'Vinci\Domain\Pricing\PriceCalculator',
            'Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider',
            'Vinci\Domain\Promotion\Types\Discount\DiscountPromotionProvider',
            'Vinci\Domain\Recomendations\Products\Service\ProductRecommendedService',
            'Vinci\Domain\Showcase\StaticShowcases\StaticShowcasesProvider'
        ];
    }
}