<?php

namespace Vinci\Domain\Customer;

class Stats
{

    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function orders()
    {
        return $this->customer->getOrders()->count();
    }

}