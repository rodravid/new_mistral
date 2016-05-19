<?php

namespace Vinci\Domain\ShoppingCart\Events\Subscribers;

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

    public function onItemIsRemoved($event)
    {
        //
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