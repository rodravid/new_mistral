<?php

namespace Vinci\Domain\Producer;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class ProducerValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [

    ];

}