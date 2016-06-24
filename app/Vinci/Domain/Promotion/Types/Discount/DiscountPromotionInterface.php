<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Vinci\Domain\Promotion\PromotionInterface;

interface DiscountPromotionInterface extends PromotionInterface
{

    public function getPriceConfiguration();

}