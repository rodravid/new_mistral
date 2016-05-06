<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Contracts\Priceable;

interface PriceCalculator
{

    public function calculate(Priceable $subject);

}