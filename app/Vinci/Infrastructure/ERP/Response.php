<?php

namespace Vinci\Infrastructure\ERP;

abstract class Response
{
    private $raw;

    public function __construct($raw)
    {
        $this->raw = $raw;
    }
    
    public function getRaw()
    {
        return $this->raw;
    }

}