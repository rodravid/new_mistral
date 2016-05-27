<?php

namespace Vinci\Domain\Shipping\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Carrier\CarrierInterface;
use Vinci\Domain\Carrier\CarrierMetric;
use Vinci\Domain\Shipping\Calculator\ShippingCalculatorFactory;
use Vinci\Domain\Shipping\Contracts\ShippingCarrierLocator as Locator;
use Vinci\Domain\Shipping\ShippableInterface;
use Vinci\Domain\Shipping\ShippingOption;


class ShippingService
{

    protected $carrierLocator;

    protected $calculatorFactory;

    public function __construct(
        Locator $carrierLocator,
        ShippingCalculatorFactory $calculatorFactory
    ) {
        $this->carrierLocator = $carrierLocator;
        $this->calculatorFactory = $calculatorFactory;
    }

    public function getShippingOptionsFor(PostalCode $postalCode, ShippableInterface $shippable)
    {
        $shippingOptions = new ArrayCollection;

        $carriers = $this->locateCarriers($postalCode, $shippable);

        foreach ($carriers as $carrier) {

            $metric = $this->getShippingMetric($postalCode, $shippable, $carrier);

            $shipping = $this->getShippingOption($shippable, $carrier, $metric);

            $shippingOptions->add($shipping);
        }

        return $shippingOptions;
    }

    public function getShippingByLowestPrice(PostalCode $postalCode, ShippableInterface $shippable)
    {
        $options = $this->getShippingOptionsFor($postalCode, $shippable);

        $criteria = Criteria::create()->orderBy(['price' => Criteria::ASC]);

        return $options->matching($criteria)->first();
    }

    protected function getShippingOption(ShippableInterface $shippable, CarrierInterface $carrier, CarrierMetric $metric)
    {
        $calculator = $this->getShippingCalculatorFor($carrier);

        $price = $calculator->calculatePrice($shippable, $metric);

        $deadline = $calculator->calculateDeadline($shippable, $metric);

        return new ShippingOption($price, $deadline, $carrier);
    }

    public function locateCarriers(PostalCode $postalCode, ShippableInterface $shippable)
    {
        return $this->carrierLocator->locate($postalCode, $shippable);
    }

    protected function getShippingCalculatorFor(CarrierInterface $carrier)
    {
        return $this->calculatorFactory->make($carrier->getShippingCalculator());
    }

    protected function getShippingMetric(PostalCode $postalCode, ShippableInterface $shippable, CarrierInterface $carrier)
    {

        if ($carrier->isDefault()) {
            return $carrier->getMetrics()->first();
        }

        $weight = $shippable->getShippingWeight();
        $postalCode = (int) $postalCode->getCode();

        $expr = Criteria::expr();

        $criteria = Criteria::create()
            ->where($expr->andX(
                $expr->lte('initialTrack', $postalCode),
                $expr->gte('finalTrack', $postalCode)
            ))
            ->andWhere($expr->andX(
                $expr->lte('initialWeight', $weight),
                $expr->gte('finalWeight', $weight)
            ));
        
        return $carrier->getMetricsMatching($criteria)->first();
    }

}