<?php

namespace Vinci\Domain\Dollar;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class DollarValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];

}