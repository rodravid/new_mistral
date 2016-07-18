<?php

namespace Vinci\Domain\ERP\Customer\Events;

use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class CustomerWasSavedOnErp extends ErpRequestEvent
{

    public $customer;

    public function __construct(Customer $customer, $request = null, $response = null, $user)
    {
        parent::__construct($request, $response, $user);
        
        $this->customer = $customer;
    }
    
    public function getCustomer()
    {
        return $this->customer;
    }

}