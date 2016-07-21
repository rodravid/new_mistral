<?php

namespace Vinci\Domain\ERP\Order\Events;

use Exception;
use Vinci\Domain\ERP\Events\ErpRequestEvent;
use Vinci\Domain\ERP\Order\Commands\UpdateShippingAddressCommand;

class ShippingAddressUpdateFailed extends ErpRequestEvent
{

    public $command;

    public $exception;

    public function __construct(UpdateShippingAddressCommand $command, $request = null, $response = null, Exception $exception = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
        $this->exception = $exception;
    }
    
    public function getCommand()
    {
        return $this->command;
    }
    
    public function getException()
    {
        return $this->exception;
    }

}