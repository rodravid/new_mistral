<?php

namespace Vinci\Domain\Search;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\Search\Product\ProductIndexerService;
use Vinci\Domain\Search\Product\ProductSearchService;

class SearchServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->singleton('Vinci\Domain\Search\Product\ProductSearchService', function() {
            return new ProductSearchService(
                $this->app->make('Elasticsearch\ClientBuilder'),
                $this->app['config'],
                $this->app['product.repository'],
                $this->app->make('Vinci\App\Core\Services\Presenter\Presenter')
            );
        });

        $this->app->alias('Vinci\Domain\Search\Product\ProductSearchService', 'elasticsearch.products');

        $this->app->singleton('Vinci\Domain\Search\Product\ProductIndexerService', function() {
            return new ProductIndexerService(
                $this->app['elasticsearch.products']->getClient(),
                $this->app['product.repository']
            );
        });

    }

}