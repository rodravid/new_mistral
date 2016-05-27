<?php

namespace Vinci\Domain\Shipping\Contracts;

use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Shipping\ShippableInterface;

interface ShippingCarrierLocator
{

    public function locate(PostalCode $postalCode, ShippableInterface $shippable);

}