<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Contracts\Price;
use Vinci\Domain\Promotion\DiscountPromotion\Contracts\DiscountPromotion;

class StandardPriceCalculator implements PriceCalculator
{

    protected $promotion;

    public function withDiscountPromotion(DiscountPromotion $discountPromotion)
    {
        $this->promotion = $discountPromotion;
        return $this;
    }

    public function calculate(Price $subject)
    {
        return $subject->getPrice();
    }
}