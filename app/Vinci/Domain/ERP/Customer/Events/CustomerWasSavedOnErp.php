<?php

namespace Vinci\Domain\ERP\Customer\Events;

use Vinci\Domain\ERP\Customer\Commands\SaveCustomerCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class CustomerWasSavedOnErp extends ErpRequestEvent
{

    public $command;

    public function __construct(SaveCustomerCommand $command, $request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

}