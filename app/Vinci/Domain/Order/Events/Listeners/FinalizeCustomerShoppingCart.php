<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class FinalizeCustomerShoppingCart
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
        $order = $event->order;

        if ($order->hasShoppingCart()) {

            $cart = $order->getShoppingCart();

            $cart->setStatus(ShoppingCartInterface::STATUS_FINALIZED);

            $this->cartService->save($cart);

            $this->cartContext->resetCurrentCartIdentifier();

        }

    }

}