<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class CloseCustomerAbandonedCarts
{

    private $cartService;

    private $cartContext;

    public function __construct(ShoppingCartService $cartService, ShoppingCartContext $cartContext)
    {
        $this->cartService = $cartService;
        $this->cartContext = $cartContext;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $this->cartService->closeAbandonedCarts($event->order->getCustomer());

        $this->cartContext->resetCurrentCartIdentifier();
    }

}