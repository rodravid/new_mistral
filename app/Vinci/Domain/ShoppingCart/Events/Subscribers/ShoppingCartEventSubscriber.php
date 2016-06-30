<?php

namespace Vinci\Domain\ShoppingCart\Events\Subscribers;

use Vinci\Domain\ShoppingCart\Events\ItemWasRemoved;

class ShoppingCartEventSubscriber
{

    public function onNewItemIsAdded($event)
    {
        //
    }

    public function onItemQuantityIsIncremented($event)
    {
        //
    }

    public function onItemQuantityIsDecremented($event)
    {
        //
    }

    public function onItemIsRemoved(ItemWasRemoved $event)
    {
        $cart = $event->item->getShoppingCart();


    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\ShoppingCart\Events\NewItemWasAdded',
            'Vinci\Domain\ShoppingCart\Events\Subscribers\ShoppingCartEventSubscriber@onNewItemIsAdded'
        );

        $events->listen(
            'Vinci\Domain\ShoppingCart\Events\ItemQuantityWasIncremented',
            'Vinci\Domain\ShoppingCart\Events\Subscribers\ShoppingCartEventSubscriber@onItemQuantityIsIncremented'
        );

        $events->listen(
            'Vinci\Domain\ShoppingCart\Events\ItemQuantityWasDecremented',
            'Vinci\Domain\ShoppingCart\Events\Subscribers\ShoppingCartEventSubscriber@onItemQuantityIsDecremented'
        );

        $events->listen(
            'Vinci\Domain\ShoppingCart\Events\ItemWasRemoved',
            'Vinci\Domain\ShoppingCart\Events\Subscribers\ShoppingCartEventSubscriber@onItemIsRemoved'
        );
    }

}