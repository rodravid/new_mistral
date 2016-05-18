<?php

namespace Vinci\Domain\ShoppingCart\Provider;

use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

interface ShoppingCartProvider
{

    public function getShoppingCart();

    public function setShoppingCart(ShoppingCartInterface $shoppingCart);

}