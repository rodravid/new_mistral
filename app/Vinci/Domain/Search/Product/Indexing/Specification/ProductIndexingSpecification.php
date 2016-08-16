<?php

namespace Vinci\Domain\Search\Product\Indexing\Specification;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\Specification\AbstractSpecification;
use Vinci\Domain\Specification\AndSpecification;
use Vinci\Domain\Specification\Product\ProductIsOnlineSpecification;
use Vinci\Domain\Specification\Product\ProductPurchasableSpecification;

class ProductIndexingSpecification extends AbstractSpecification
{

    public function isSatisfiedBy(ProductInterface $product)
    {
        $spec = new AndSpecification(
            new ProductIsOnlineSpecification,
            new ProductPurchasableSpecification
        );

        return $spec->isSatisfiedBy($product) && $product->getProductType()->getId() != ProductType::TYPE_PACKING;
    }

}