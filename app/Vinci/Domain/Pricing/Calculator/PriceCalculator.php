<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Contracts\Price;

interface PriceCalculator
{

    public function calculate(Price $subject);

}