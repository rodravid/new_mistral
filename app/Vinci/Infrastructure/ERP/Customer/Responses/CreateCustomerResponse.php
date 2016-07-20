<?php

namespace Vinci\Infrastructure\ERP\Customer\Responses;

use Vinci\Infrastructure\ERP\Response;

class CreateCustomerResponse extends Response
{

    private $message;

    public function __construct($raw, $message)
    {
        parent::__construct($raw);
        
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function wasSuccessfullyCreated()
    {
        return strpos($this->message, 'sucesso') !== false;
    }

}