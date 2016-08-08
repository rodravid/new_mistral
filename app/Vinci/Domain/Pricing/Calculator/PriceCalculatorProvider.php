<?php

namespace Vinci\Domain\Pricing\Calculator;

use Illuminate\Contracts\Container\Container;
use Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider as PriceCalculatorProviderInterface;

class PriceCalculatorProvider implements PriceCalculatorProviderInterface
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function getCalculator()
    {
        return $this->container->make(StandardPriceCalculator::class);
    }
    
}