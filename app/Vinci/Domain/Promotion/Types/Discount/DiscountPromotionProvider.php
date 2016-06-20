<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Vinci\Domain\Product\ProductInterface;

interface DiscountPromotionProvider
{

    const CACHE_KEY = '_discount_promotion_';

    public function findValidPromotionFor(ProductInterface $product);

}