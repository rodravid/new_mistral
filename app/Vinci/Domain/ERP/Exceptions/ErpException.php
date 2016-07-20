<?php

namespace Vinci\Domain\ERP\Exceptions;

use Exception;

class ErpException extends Exception
{

    protected $response;

    public function __construct($message = '', $response = null)
    {
        parent::__construct($message);

        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

}