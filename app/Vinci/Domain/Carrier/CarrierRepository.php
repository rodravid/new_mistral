<?php

namespace Vinci\Domain\Carrier;

interface CarrierRepository
{

    public function findByPostalCodeAndWeight($postalCode, $weight);

    public function getDefaultCarrier();

}