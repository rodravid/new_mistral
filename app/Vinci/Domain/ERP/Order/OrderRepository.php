<?php

namespace Vinci\Domain\ERP\Order;

interface OrderRepository
{

    public function create(Order $order);

}