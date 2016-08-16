<?php

namespace Vinci\Domain\Specification\Product;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Specification\AbstractSpecification;

class ProductIsOnlineSpecification extends AbstractSpecification
{

    public function isSatisfiedBy(ProductInterface $product)
    {
        return $product->isOnline();
    }

}