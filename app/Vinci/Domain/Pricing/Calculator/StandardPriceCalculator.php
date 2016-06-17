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
        $finalPrice = $this->convertAmountToReal($subject);

        $this->applyDiscountsIfNecessary($subject, $finalPrice);

        return $this->parseValueAndReset($finalPrice);
    }

    protected function applyDiscountsIfNecessary(CalculablePrice $subject, &$finalPrice)
    {
        if ($this->shouldCalculateDiscounts()) {
            $finalPrice -= $this->calculateDiscounts($subject);
        }
    }

    public function calculateDiscounts(CalculablePrice $subject)
    {
        $config = $this->getPriceConfiguration();

        $finalPrice = $this->convertAmountToReal($subject);

        return $this->calcDiscountByType(
            $finalPrice,
            $config->getDiscountType(),
            $config->getDiscountAmount()
        );
    }

    protected function convertAmountToReal(CalculablePrice $subject)
    {
        $dollar = $this->normalizeDollarAmount($this->getPriceConfiguration()->getCurrencyAmount());

        return (double) $subject->getAmount() * $dollar;
    }

    protected function normalizeDollarAmount($amount)
    {
        return (double) $amount > 0 ?
            $amount : $this->dollarProvider->getCurrentDollarAmount();
    }

}