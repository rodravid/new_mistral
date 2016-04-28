<?php

namespace Vinci\Domain\Ecommerce\Purchase\Contracts;

interface Purchasable
{

    public function getTitle();

    public function getPrice();

    public function getOldPrice();

}