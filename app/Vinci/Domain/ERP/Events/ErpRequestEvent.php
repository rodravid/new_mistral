<?php

namespace Vinci\Domain\ERP\Events;

use Vinci\Domain\Common\Event\Event;

abstract class ErpRequestEvent extends Event
{

    public $response;

    public $request;

    public function __construct($request = null, $response = null)
    {
        $this->setRequest($request);
        $this->setResponse($response);
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

}