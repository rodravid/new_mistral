<?php

namespace Vinci\App\Integration\ERP;

use Illuminate\Support\ServiceProvider;
use Vinci\App\Integration\ERP\State\DoctrineStateRepository;
use Vinci\App\Integration\ERP\State\ErpStateApi;
use Vinci\App\Integration\ERP\State\StateApi;
use Vinci\App\Integration\ERP\State\StateRepository;
use Vinci\App\Integration\ERP\State\StateService;
use Vinci\Domain\ERP\Customer\CustomerRepository;
use Vinci\Domain\ERP\Order\OrderRepository;
use Vinci\Domain\ERP\Product\ProductFactory;
use Vinci\Domain\ERP\Product\ProductRepository;
use Vinci\Infrastructure\ERP\Customer\CustomerRepositoryERP;
use Vinci\Infrastructure\ERP\Order\OrderRepositoryERP;
use Vinci\Infrastructure\ERP\Product\ProductRepositoryERP;

class IntegrationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerProductServices();

        $this->loadViewsFrom(__DIR__ . '/../../../Infrastructure/ERP', 'erp');
    }

    private function registerProductServices()
    {
        $this->app->singleton(ProductRepository::class, function() {
            return $this->app->make(ProductRepositoryERP::class);
        });

        $this->app->singleton(CustomerRepository::class, function() {
            return $this->app->make(CustomerRepositoryERP::class);
        });

        $this->app->singleton(OrderRepository::class, function() {
            return $this->app->make(OrderRepositoryERP::class);
        });

        $this->app->singleton(ProductFactory::class, function() {
            return $this->app->make(\Vinci\Infrastructure\ERP\Product\ProductFactory::class);
        });

        $this->app->singleton(StateApi::class, function () {
            return $this->app->make(ErpStateApi::class);
        });

        $this->app
            ->when(StateService::class)
            ->needs(StateRepository::class)
            ->give(function () {
                return $this->app->make(\Vinci\Domain\Address\State\StateRepository::class);
            });
    }

}