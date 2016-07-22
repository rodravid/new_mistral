<?php

namespace Vinci\Domain\ERP\Order\Events;

use Exception;
use Vinci\Domain\ERP\Order\Commands\GetShippingAddressIdCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class AddressErpCheckFailed extends ErpRequestEvent
{

    public $command;

    public $exception;

    public function __construct(GetShippingAddressIdCommand $command, $request = null, $response = null, Exception $exception = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
        $this->exception = $exception;
    }

    public function getException()
    {
        return $this->exception;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

}