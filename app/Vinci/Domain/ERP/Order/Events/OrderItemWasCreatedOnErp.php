<?php

namespace Vinci\Domain\ERP\Order\Events;

use Vinci\Domain\ERP\Order\Commands\CreateOrderItemCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class OrderItemWasCreatedOnErp extends ErpRequestEvent
{

    public $command;

    public function __construct(CreateOrderItemCommand $command, $request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        $this->command = $command;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

}