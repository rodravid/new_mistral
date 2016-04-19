<?php

namespace Vinci\Domain\Grape;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class GrapeValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [

    ];

}