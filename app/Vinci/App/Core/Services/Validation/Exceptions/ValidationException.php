<?php

namespace Vinci\App\Core\Services\Validation\Exceptions;

use Exception;

class ValidationException extends Exception
{

    protected $errors;

    public function __construct($errors = null)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}