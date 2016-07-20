<?php

namespace Vinci\Domain\ERP\Order\Events;

use Exception;
use Vinci\Domain\ERP\Order\Commands\CreateOrderItemCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class OrderItemCreationErpFailed extends ErpRequestEvent
{

    public $command;

    public $exception;

    public function __construct(CreateOrderItemCommand $command, $request = null, $response = null, Exception $exception = null)
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