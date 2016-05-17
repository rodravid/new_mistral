<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider as PriceCalculatorProviderInterface;

class PriceCalculatorProvider implements PriceCalculatorProviderInterface
{

    protected $calculator;

    public function __construct(PriceCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function getCalculator()
    {
        return $this->calculator;
    }
}