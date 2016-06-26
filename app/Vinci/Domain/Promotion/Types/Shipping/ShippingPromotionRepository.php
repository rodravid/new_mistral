<?php

namespace Vinci\Domain\Promotion\Types\Shipping;

use Vinci\Domain\Address\PostalCode;

interface ShippingPromotionRepository
{

    public function findOneByPostalCodeAndAmount(PostalCode $postalCode, $amount);

}