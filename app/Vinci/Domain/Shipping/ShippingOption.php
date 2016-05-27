<?php

namespace Vinci\Domain\Shipping;

use Vinci\Domain\Carrier\CarrierInterface;

class ShippingOption
{

    private $price;

    private $deadline;

    private $carrier;

    public function __construct($price, $deadline, CarrierInterface $carrier)
    {
        $this->price = (double) $price;
        $this->deadline = (int) $deadline;
        $this->carrier = $carrier;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

}