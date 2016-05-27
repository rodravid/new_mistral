<?php

namespace Vinci\Domain\ShoppingCart;

use Vinci\Domain\Common\AggregateRoot;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Shipping\ShippableInterface;

interface ShoppingCartInterface extends AggregateRoot, ShippableInterface
{

    public function getId();

    public function setCustomer(Customer $customer);

    public function findItemByProduct(ProductInterface $product);

    public function getItems();

    public function countItems();

    public function getSubtotal();

    public function getTotal();

}