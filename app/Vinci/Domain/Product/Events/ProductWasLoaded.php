<?php

namespace Vinci\Domain\Product\Events;

use Vinci\Domain\Common\Event\Event;

class ProductWasLoaded extends Event
{

    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

}