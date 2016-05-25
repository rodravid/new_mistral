<?php

namespace Vinci\Domain\Order\Factory;

use Vinci\Domain\Order\Order;

class OrderFactory
{

    public function make()
    {
        return new Order;
    }

}