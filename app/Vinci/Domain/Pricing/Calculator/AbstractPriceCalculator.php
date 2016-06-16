<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Calculator\Exceptions\PriceCalculatorException;
use Vinci\Domain\Pricing\Contracts\CalculablePrice;
use Vinci\Domain\Pricing\Contracts\PriceConfigurationProvider;

abstract class AbstractPriceCalculator implements PriceCalculator
{

    protected $calcDiscounts = true;

    protected $priceConfigurationProvider;

    public function setPriceConfigurationProvider(PriceConfigurationProvider $provider)
    {
        $this->priceConfigurationProvider = $provider;
        return $this;
    }

    public function getPriceConfigurationProvider()
    {
        return $this->priceConfigurationProvider;
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

    public function calculateDiscounts(CalculablePrice $subject)
    {
        $config = $this->getPriceConfiguration();

        return $this->calcDiscountByType(
            $subject->getAmount(),
            $config->getDiscountType(),
            $config->getDiscountAmount()
        );
    }

    public function calcDiscountByType($amount, $type, $discountAmount)
    {
        $discountAmount = (double) $discountAmount;

        switch ($type) {

            case 'percent':
                return $amount * ($discountAmount / 100);
                break;

            case 'fixed':
                return $discountAmount;
                break;
        }

        return 0;
    }

    public function getPriceConfiguration()
    {
        if (! $this->priceConfigurationProvider) {
            throw new PriceCalculatorException('The PriceConfigurationProvider is not defined.');
        }

        return $this->priceConfigurationProvider->getConfiguration();
    }

}