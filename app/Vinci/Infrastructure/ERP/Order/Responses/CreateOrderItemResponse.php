<?php

namespace Vinci\Infrastructure\ERP\Order\Responses;

use Vinci\Infrastructure\ERP\Response;

class CreateOrderItemResponse extends Response
{

    private $message;

    public function __construct($raw, $message = null)
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