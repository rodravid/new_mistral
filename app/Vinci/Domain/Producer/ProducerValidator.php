<?php

namespace Vinci\Domain\Producer;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class ProducerValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'region_id' => 'required'
    ];

    protected $messages = [
        'region_id.required' => 'Você deve selecionar uma região.'
    ];

}