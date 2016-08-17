<?php

namespace Vinci\Domain\Product\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Product\ProductInterface;

class ProductWasUpdated extends Event
{

    public $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

}