<?php

namespace Vinci\Domain\Product\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Product\ProductInterface;

class ProductWasUpdated extends Event
{

    public $product;

    private $raisedByUserInteraction;

    public function __construct(ProductInterface $product, $raisedByUserInteraction = false)
    {
        $this->product = $product;
        $this->raisedByUserInteraction = $raisedByUserInteraction;
    }

    public function setRaisedByUserInteration($value = true)
    {
        $this->raisedByUserInteraction = $value;
        return $this;
    }

    public function wasRaisedByUserInteration()
    {
        return $this->raisedByUserInteraction;
    }

}