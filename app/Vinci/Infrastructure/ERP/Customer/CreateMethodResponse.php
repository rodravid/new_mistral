<?php

namespace Vinci\Infrastructure\ERP\Customer;

use Vinci\Infrastructure\ERP\Response;

class CreateMethodResponse extends Response
{

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function wasSuccessfullyCreated()
    {
        return strpos($this->message, 'sucesso') !== false;
    }

}