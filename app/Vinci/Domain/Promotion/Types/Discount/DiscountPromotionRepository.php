<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Vinci\Domain\Product\ProductInterface;

interface DiscountPromotionRepository
{

    public function findOneByProduct(ProductInterface $product);

}