<?php

namespace Vinci\Domain\Pricing\Contracts;

interface Priceable
{

    public function getPrice($channel = null);

    public function getSalePrice();

    public function getOriginalPrice();

}