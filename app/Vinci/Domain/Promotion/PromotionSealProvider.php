<?php

namespace Vinci\Domain\Promotion;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionService;

class PromotionSealProvider
{

    private $discountPromotionService;

    public function __construct(DiscountPromotionService $discountPromotionService)
    {
        $this->discountPromotionService = $discountPromotionService;
    }

    public function provideFor(ProductInterface $product)
    {
        if ($promotion = $this->discountPromotionService->findValidPromotionFor($product)) {

            if ($promotion->hasSealImage()) {
                return $promotion->getSealImage()->getWebPath();
            }
        }
    }

}