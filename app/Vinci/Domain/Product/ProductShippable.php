<?php

namespace Vinci\Domain\Product;

use Vinci\Domain\Shipping\ShippableInterface;

class ProductShippable implements ShippableInterface
{

    private $itemQuantity;

    private $boxQuantity;

    private $product;

    public function __construct(ProductInterface $product, $itemQuantity = 1, $boxQuantity = 0)
    {
        $this->itemQuantity = (int) $itemQuantity;
        $this->boxQuantity = (int) $boxQuantity;
        $this->product = $product;
    }

    public function getShippingWeight()
    {
        $quantity = $this->itemQuantity;

        if ($this->boxQuantity > 0) {
            $quantity += $this->product->getPackSize() * $this->boxQuantity;
        }

        return $quantity * $this->product->getDimension()->getWeight();
    }
}