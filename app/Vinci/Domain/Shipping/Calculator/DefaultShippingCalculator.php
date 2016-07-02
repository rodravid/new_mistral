<?php

namespace Vinci\Domain\Shipping\Calculator;

use Vinci\Domain\Carrier\CarrierMetricInterface;
use Vinci\Domain\Deadline\DeadlineRepository;
use Vinci\Domain\Shipping\ShippableInterface;

class DefaultShippingCalculator implements ShippingCalculatorInterface
{

    private $deadlineRepository;

    public function __construct(DeadlineRepository $deadlineRepository)
    {
        $this->deadlineRepository = $deadlineRepository;
    }

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
        return $carrierMetric->getDeadline() + $shippable->getDeadline() + $this->deadlineRepository->getLast()->getDays();
    }
}