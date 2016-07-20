<?php

namespace Vinci\Domain\ERP\Customer\Events;

use Exception;
use Vinci\Domain\ERP\Customer\Commands\SaveCustomerCommand;
use Vinci\Domain\ERP\Events\ErpRequestEvent;

class CustomerSaveOnErpFailed extends ErpRequestEvent
{

    public $command;

    public $exception;

    public function __construct(SaveCustomerCommand $command, $request = null, $response = null, Exception $exception = null)
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