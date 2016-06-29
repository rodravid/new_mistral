<?php

namespace Vinci\Domain\Order;

use Vinci\Domain\Shipping\ShippableInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

interface OrderInterface extends ShippableInterface
{
    public function getShoppingCart();

    public function setShoppingCart(ShoppingCartInterface $cart = null);
}