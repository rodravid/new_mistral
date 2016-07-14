<?php

namespace Vinci\Domain\ERP\Order;

class OrderFactory
{

    public function getNewInstance()
    {
        return new Order;
    }

}