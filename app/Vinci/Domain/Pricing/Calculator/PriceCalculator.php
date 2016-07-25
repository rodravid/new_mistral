<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Contracts\CalculablePrice;

interface PriceCalculator
{

    public function skipDiscounts($skip = true);

    public function shouldCalculateDiscounts();

    public function getPriceConfiguration();

    public function calculate(CalculablePrice $subject);

    public function calculateDiscounts(CalculablePrice $subject);

    public function calculateIpi(CalculablePrice $subject);

}