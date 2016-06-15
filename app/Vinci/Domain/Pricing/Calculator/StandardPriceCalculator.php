<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Product\ProductVariantPrice;

class StandardPriceCalculator implements PriceCalculator
{

    protected $calcDiscounts = true;

    public function __construct()
    {

    }

    public function skipDiscounts($skip = true)
    {
        $this->calcDiscounts = ! $skip;
        return $this;
    }

    public function calculate(ProductVariantPrice $price)
    {
        return (double) $price->getPrice();
    }

    public function calculateDiscounts(ProductVariantPrice $price)
    {

    }

}