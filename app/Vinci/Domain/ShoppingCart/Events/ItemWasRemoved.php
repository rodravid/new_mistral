<?php

namespace Vinci\Domain\ShoppingCart\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

class ItemWasRemoved extends Event
{

    public $item;

    public function __construct(ShoppingCartItem $item)
    {
        $this->item = $item;
    }

}