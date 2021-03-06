<?php

namespace Vinci\Domain\Customer\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Customer\Customer;

class CustomerPasswordWasChanged extends Event
{

    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

}