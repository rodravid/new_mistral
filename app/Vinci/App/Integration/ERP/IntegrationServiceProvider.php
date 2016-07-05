<?php

namespace Vinci\App\Integration\ERP;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\ERP\Product\ProductFactory;
use Vinci\Domain\ERP\Product\ProductRepository;
use Vinci\Infrastructure\ERP\Product\ProductRepositoryERP;

class IntegrationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerProductServices();
    }

    private function registerProductServices()
    {
        $this->app->singleton(ProductRepository::class, function() {
            return $this->app->make(ProductRepositoryERP::class);
        });

        $this->app->singleton(ProductFactory::class, function() {
            return $this->app->make(\Vinci\Infrastructure\ERP\Product\ProductFactory::class);
        });
    }

}