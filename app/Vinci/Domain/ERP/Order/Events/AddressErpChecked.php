<?php

namespace Vinci\Domain\ERP\Order\Events;

use Vinci\Domain\ERP\Order\Commands\GetShippingAddressIdCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class AddressErpChecked extends ErpRequestEvent
{

    public $command;

    public function __construct(GetShippingAddressIdCommand $command, $request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

}