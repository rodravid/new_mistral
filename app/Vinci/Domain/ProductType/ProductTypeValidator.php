<?php

namespace Vinci\Domain\ProductType;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class ProductTypeValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [

    ];

}