<?php

namespace Vinci\Domain\Product;

use Vinci\Domain\Inventory\Contracts\Stockable;
use Vinci\Domain\Pricing\Contracts\Priceable;

interface ProductVariantInterface extends Priceable, Stockable
{

    public function getProduct();

}