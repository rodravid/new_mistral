<?php

namespace Vinci\Domain\Validation;
use Exception;

class ValidationException extends Exception
{

    protected $errors;

    public function __construct($message = '', $errors = null)
    {
        parent::__construct($message);

        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}