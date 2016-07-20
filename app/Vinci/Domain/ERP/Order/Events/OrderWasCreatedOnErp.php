<?php

namespace Vinci\Domain\ERP\Order\Events;

use Vinci\Domain\ERP\Order\Commands\SaveOrderCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class OrderWasCreatedOnErp extends ErpRequestEvent
{

    public $command;

    public function __construct(SaveOrderCommand $command, $request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

}