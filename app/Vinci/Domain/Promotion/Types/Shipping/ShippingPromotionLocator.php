<?php

namespace Vinci\Domain\Promotion\Types\Shipping;

use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

interface ShippingPromotionLocator
{
    
    public function findOneForShoppingCart(ShoppingCartInterface $shoppingCart, PostalCode $postalCode);

}