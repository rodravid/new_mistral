<?php

namespace Vinci\Domain\Country;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class CountryValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [

    ];

}