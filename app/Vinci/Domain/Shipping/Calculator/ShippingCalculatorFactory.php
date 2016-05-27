<?php

namespace Vinci\Domain\Shipping\Calculator;

class ShippingCalculatorFactory
{

    public function make($type)
    {
        return new DefaultShippingCalculator();
    }
    
}