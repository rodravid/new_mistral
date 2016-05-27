<?php

namespace Vinci\Domain\Shipping\Calculator;

use Vinci\Domain\Carrier\CarrierMetricInterface;
use Vinci\Domain\Shipping\ShippableInterface;

interface ShippingCalculatorInterface
{

    const DEFAULT_CALCULATOR = 'default';

    public function calculatePrice(ShippableInterface $shippable, CarrierMetricInterface $carrierMetric);

    public function calculateDeadline(ShippableInterface $shippable, CarrierMetricInterface $carrierMetric);

}