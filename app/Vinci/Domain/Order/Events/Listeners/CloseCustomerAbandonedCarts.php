<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class CloseCustomerAbandonedCarts
{

    private $cartService;

    public function __construct(ShoppingCartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $this->cartService->closeAbandonedCarts($event->order->getCustomer());
    }

}