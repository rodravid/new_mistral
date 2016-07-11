<?php

namespace Vinci\Domain\Customer\Events;

use Vinci\Domain\Common\Event\Event;

class CustomerWasCreated extends Event
{

    public $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

}