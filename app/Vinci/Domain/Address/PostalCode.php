<?php

namespace Vinci\Domain\Address;

class PostalCode
{

    protected $code;

    public function __construct($postalCode)
    {
        $this->code = only_numbers($postalCode);
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