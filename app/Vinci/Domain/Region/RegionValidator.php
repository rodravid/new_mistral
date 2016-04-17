<?php

namespace Vinci\Domain\Region;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class RegionValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [

    ];

}