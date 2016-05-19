<?php

namespace Vinci\Domain\ShoppingCart\Resolver\Contracts;

use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

interface ItemResolver
{

    public function resolve(ShoppingCartInterface $shoppingCart, ProductVariantInterface $productVariant, array $params);

}