<?php

namespace Vinci\Domain\ShoppingCart;

use Vinci\Domain\Common\AggregateRoot;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Product\ProductInterface;

interface ShoppingCartInterface extends AggregateRoot
{

    public function getId();

    public function setCustomer(Customer $customer);

    public function findItemByProduct(ProductInterface $product);

}