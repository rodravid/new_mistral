<?php

namespace Vinci\Domain\Product\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Vinci\Domain\Product\Events\ProductWasUpdated;
use Vinci\Domain\Product\Jobs\SyncProductWithElasticsearch;

class SendProductToElasticsearchIndexingQueue
{
    
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(ProductWasUpdated $event)
    {
//        $this->dispatcher->dispatch(
//            (new SyncProductWithElasticsearch($event->product->getId()))
//                ->onQueue('vinci-elasticsearch-products')
//        );
    }

}