<?php

namespace Vinci\Domain\ERP\Customer\Events;

use Exception;
use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class CustomerSaveOnErpFailed extends ErpRequestEvent
{

    public $customer;

    public $exception;

    public function __construct(Customer $customer, $request = null, $response = null, $user, Exception $exception)
    {
        parent::__construct($request, $response, $user);

        $this->customer = $customer;
        $this->exception = $exception;
    }

    public function getException()
    {
        return $this->exception;
    }
    
    public function getCustomer()
    {
        return $this->customer;
    }

}