<?php

namespace Vinci\Domain\Shipping;

interface ShippableInterface
{

    public function getShippingWeight();

    public function getDeadline();

}