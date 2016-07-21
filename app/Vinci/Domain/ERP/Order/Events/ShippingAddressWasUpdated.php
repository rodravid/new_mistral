<?php

namespace Vinci\Domain\ERP\Order\Events;

use Vinci\Domain\ERP\Events\ErpRequestEvent;
use Vinci\Domain\ERP\Order\Commands\UpdateShippingAddressCommand;

class ShippingAddressWasUpdated extends ErpRequestEvent
{

    public $command;

    public function __construct(UpdateShippingAddressCommand $command, $request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

}