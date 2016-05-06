<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Contracts\Priceable;

class StandardPriceCalculator implements PriceCalculator
{

    public function __construct()
    {

    }

    public function calculate(Priceable $subject)
    {

        dd($subject->getPrice());

    }
}