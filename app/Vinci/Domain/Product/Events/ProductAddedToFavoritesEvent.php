<?php

namespace Vinci\Domain\Product\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Product\ProductInterface;

class ProductAddedToFavoritesEvent extends Event
{

    public $product;

    public $customer;

    public function __construct(ProductInterface $product, CustomerInterface $customer)
    {
        $this->product = $product;
        $this->customer = $customer;
    }

}