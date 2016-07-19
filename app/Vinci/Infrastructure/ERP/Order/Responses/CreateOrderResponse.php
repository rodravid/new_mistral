<?php

namespace Vinci\Infrastructure\ERP\Order\Responses;

use Vinci\Infrastructure\ERP\Response;

class CreateOrderResponse extends Response
{

    private $orderId;

    public function __construct($raw, $orderId = null)
    {
        parent::__construct($raw);
        
        $this->orderId = $orderId;
    }

    public function getMessage()
    {
        return $this->orderId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

}