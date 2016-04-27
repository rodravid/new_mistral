<?php

namespace Vinci\Domain\Ecommerce\Purchase\Contracts;

use Vinci\Domain\Ecommerce\Sale\Contracts\SoldProduct;

interface Purchasable
{

    public function getTitle();

    public function getPrice();

    public function getOldPrice();

    public function toSoldProduct() : SoldProduct;

}