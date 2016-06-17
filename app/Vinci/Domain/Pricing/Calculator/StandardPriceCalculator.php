<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Dollar\DollarProvider;
use Vinci\Domain\Pricing\Contracts\CalculablePrice;

class StandardPriceCalculator extends AbstractPriceCalculator implements PriceCalculator
{

    protected $dollarProvider;

    public function __construct(DollarProvider $dollarProvider)
    {
        $this->dollarProvider = $dollarProvider;
    }

    public function calculate(CalculablePrice $subject)
    {
        $discounts = 0;

        if ($this->shouldCalculateDiscounts()) {
            $this->skipDiscounts();
            $discounts = $this->calculateDiscounts($subject);
        }

        return $subject->getAmount();
    }

    public function normalizeDollarAmount($amount)
    {
        return (double) ! empty($amount) ?
            $amount : $this->dollarProvider->getCurrentDollarAmount();
    }

}