<?php

namespace Vinci\Domain\Product\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Vinci\Domain\Product\Events\ProductWasUpdated;
use Vinci\Domain\Product\Jobs\SyncProductWithElasticsearch;

class SendProductToElasticsearchIndexingQueue
{
    
    private $dispatcher;

    private $config;

    public function __construct(Dispatcher $dispatcher, Repository $config)
    {
        $this->dispatcher = $dispatcher;
        $this->config = $config;
    }

    public function handle(ProductWasUpdated $event)
    {
        if ($event->wasRaisedByUserInteration()) {
            $this->dispatcher->dispatch(
                (new SyncProductWithElasticsearch($event->product->getId()))
                    ->onQueue($this->config->get('queue.products-elasticsearch'))
            );
        }
    }

}