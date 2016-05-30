<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class FinalizeCustomerShoppingCart
{

    private $cartService;

    public function __construct(ShoppingCartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $order = $event->order;

        if ($order->hasShoppingCart()) {

            $cart = $order->getShoppingCart();

            $cart->setStatus(ShoppingCartInterface::STATUS_FINALIZED);

            $this->cartService->save($cart);
        }

    }

}