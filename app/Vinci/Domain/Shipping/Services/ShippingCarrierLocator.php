<?php

namespace Vinci\Domain\Shipping\Services;

use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Carrier\CarrierRepository;
use Vinci\Domain\Shipping\Contracts\ShippingCarrierLocator as ShippingCarrierLocatorContract;
use Vinci\Domain\Shipping\Exceptions\ShippingException;
use Vinci\Domain\Shipping\ShippableInterface;

class ShippingCarrierLocator implements ShippingCarrierLocatorContract
{

    protected $carrierRepository;

    public function __construct(CarrierRepository $carrierRepository)
    {
        $this->carrierRepository = $carrierRepository;
    }

    public function locate(PostalCode $postalCode, ShippableInterface $shippable)
    {
        $carriers = $this->carrierRepository->findByPostalCodeAndWeight(
            $postalCode->getCode(),
            $shippable->getShippingWeight()
        );

        if (! empty($carriers)) {
            return $carriers;
        }

        $defaultCarrier = $this->getDefaultCarrier();

        if ($defaultCarrier) {
            return [$defaultCarrier];
        }

        throw new ShippingException('No carrier found for shipping.');
    }

    protected function getDefaultCarrier()
    {
        return $this->carrierRepository->getDefaultCarrier();
    }

}