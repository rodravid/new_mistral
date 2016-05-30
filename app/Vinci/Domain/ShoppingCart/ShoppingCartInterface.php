<?php

namespace Vinci\Domain\ShoppingCart;

use Vinci\Domain\Common\AggregateRoot;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Shipping\ShippableInterface;

interface ShoppingCartInterface extends AggregateRoot, ShippableInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_FINALIZED = 2;
    const STATUS_EXPIRED_BY_SYSTEM = 3;
    const STATUS_EXPIRED_BY_CUSTOMER = 4;
    const STATUS_DELETED = 9;

    public function getId();

    public function setCustomer(Customer $customer);

    public function findItemByProduct(ProductInterface $product);

    public function getItems();

    public function countItems();

    public function getSubtotal();

    public function getTotal();

}