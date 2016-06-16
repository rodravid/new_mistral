<?php

namespace Vinci\Domain\Pricing\Contracts;

interface PriceCalculatorProvider
{

    public function getCalculator();

    public function getPriceConfigurationResolver();

}