<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Calculator\Exceptions\PriceCalculatorException;
use Vinci\Domain\Pricing\Contracts\DiscountType;
use Vinci\Domain\Pricing\Contracts\PriceConfiguration;

abstract class AbstractPriceCalculator implements PriceCalculator
{

    protected $calcDiscounts = true;

    protected $priceConfiguration;

    public function setPriceConfiguration(PriceConfiguration $configuration)
    {
        $this->priceConfiguration = $configuration;
        return $this;
    }

    public function getPriceConfiguration()
    {
        if (! $this->priceConfiguration) {
            throw new PriceCalculatorException('The PriceConfiguration is not defined.');
        }

        return $this->priceConfiguration;
    }

    public function skipDiscounts($skip = true)
    {
        $this->calcDiscounts = ! $skip;
        return $this;
    }

    public function shouldCalculateDiscounts()
    {
        return $this->calcDiscounts;
    }

    public function calcDiscountByType($amount, $type, $discountAmount)
    {
        $discountAmount = (double) $discountAmount;

        switch ($type) {

            case DiscountType::PERCENTAGE:
                return $amount * ($discountAmount / 100);
                break;

            case DiscountType::FIXED:
                return $discountAmount;
                break;
        }

        return 0;
    }

    public function parseValueAndReset($value)
    {
        $this->calcDiscounts = true;
        return (double) round($value, 2);
    }

}