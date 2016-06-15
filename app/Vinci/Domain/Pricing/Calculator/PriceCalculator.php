<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Product\ProductVariantPrice;

interface PriceCalculator
{

    public function calculate(ProductVariantPrice $price);

    public function calculateDiscounts(ProductVariantPrice $price);

}