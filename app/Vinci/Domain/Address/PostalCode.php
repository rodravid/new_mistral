<?php

namespace Vinci\Domain\Address;

class PostalCode
{

    protected $code;

    public function __construct($postalCode)
    {
        $this->code = $postalCode;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function __toString()
    {
        return (string) $this->getCode();
    }

}