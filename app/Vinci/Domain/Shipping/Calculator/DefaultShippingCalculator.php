<?php

namespace Vinci\Domain\Shipping\Calculator;

use Vinci\Domain\Carrier\CarrierMetricInterface;
use Vinci\Domain\Shipping\ShippableInterface;

class DefaultShippingCalculator implements ShippingCalculatorInterface
{

    public function calculatePrice(ShippableInterface $shippable, CarrierMetricInterface $carrierMetric)
    {
        $finalPrice = $carrierMetric->getPrice();

        if ($carrierMetric->hasTaxes()) {

            foreach ($carrierMetric->getTaxes() as $tax) {
                $tax->apply($finalPrice);
            }

        }

        return $finalPrice;
    }

    public function calculateDeadline(ShippableInterface $shippable, CarrierMetricInterface $carrierMetric)
    {
        return $carrierMetric->getDeadline();
    }
}