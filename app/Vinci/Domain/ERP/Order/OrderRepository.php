<?php

namespace Vinci\Domain\ERP\Order;

use Vinci\Domain\ERP\Address\Address;
use Vinci\Domain\ERP\Order\Item\Item;

interface OrderRepository
{

    public function create(Order $order);

    public function createItem(Item $item);

    public function getShippingAddressId(Address $address);

    public function updateShippingAddress(Address $address);

}