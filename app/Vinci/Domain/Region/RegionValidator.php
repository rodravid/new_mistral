<?php

namespace Vinci\Domain\Region;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class RegionValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'country' => 'required'
    ];

    protected $messages = [
        'country.required' => 'Você deve selecionar um país.'
    ];

}