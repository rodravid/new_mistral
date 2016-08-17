<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\Domain\Product\Events\ProductWasUpdated;

class SynProductWithElasticsearch
{
    public function __construct()
    {

    }

    public function handle(ProductWasUpdated $event)
    {

    }

}