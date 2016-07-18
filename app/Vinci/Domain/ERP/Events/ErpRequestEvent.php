<?php

namespace Vinci\Domain\ERP\Events;

use Vinci\Domain\Common\Event\Event;

abstract class ErpRequestEvent extends Event
{

    public $response;

    public $user;

    public $request;

    public function __construct($request = null, $response = null, $user)
    {
        $this->setRequest($request);
        $this->setResponse($response);
        $this->setUser($user);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
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