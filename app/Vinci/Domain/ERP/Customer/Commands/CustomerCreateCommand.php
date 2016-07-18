<?php

namespace Vinci\Domain\ERP\Customer\Commands;

use Vinci\Domain\ERP\Customer\Customer;

class CustomerCreateCommand
{

    private $customer;

    private $userActor;

    public function __construct(Customer $customer, $userActor = null)
    {
        $this->customer = $customer;
        $this->userActor = $userActor;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getUserActor()
    {
        return $this->userActor;
    }

}