<?php

namespace Vinci\Domain\ShoppingCart\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

class ItemQuantityWasDecremented extends Event
{

    public $item;

    public $quantity;

    public function __construct(ShoppingCartItem $item, $quantity)
    {
        $this->item = $item;
        $this->quantity = $quantity;
    }

}