<?php

namespace Vinci\Domain\Search;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\Search\Product\Indexing\IndexManager;
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
                $this->app->make('Vinci\Domain\Search\Filter\FilterFactory'),
                $this->app->make('Vinci\Domain\Search\Suggester\SuggesterFactory'),
                $this->app['product.repository'],
                $this->app->make('Vinci\App\Core\Services\Presenter\Presenter')
            );
        });

        $this->app->alias('Vinci\Domain\Search\Product\ProductSearchService', 'elasticsearch.products');

        $this->app->singleton(IndexManager::class, function() {
            return new IndexManager($this->app['elasticsearch.products']->getClient());
        });

        $this->app->singleton('Vinci\Domain\Search\Product\ProductIndexerService', function() {
            return new ProductIndexerService(
                $this->app['elasticsearch.products']->getClient(),
                $this->app->make(IndexManager::class),
                $this->app['product.repository'],
                $this->app['showcase.repository'],
                $this->app['showcase.static.provider']
            );
        });

    }

}