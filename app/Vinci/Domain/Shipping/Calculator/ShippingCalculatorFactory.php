<?php

namespace Vinci\Domain\Shipping\Calculator;

use Illuminate\Contracts\Container\Container;

class ShippingCalculatorFactory
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make($type)
    {
        return $this->container->make(DefaultShippingCalculator::class);
    }
    
}