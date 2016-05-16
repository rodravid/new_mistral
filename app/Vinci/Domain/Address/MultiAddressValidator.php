<?php

namespace Vinci\Domain\Address;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class MultiAddressValidator extends LaravelValidator
{

    protected $rules = [
        'addresses.*.type' => 'required',
        'addresses.*.postal_code' => 'required',
        'addresses.*.nickname' => 'required_if:addresses.*.type,3',
        'addresses.*.public_place' => 'required',
        'addresses.*.address' => 'required',
        'addresses.*.number' => 'required',
        'addresses.*.district' => 'required',
        'addresses.*.country' => 'required',
        'addresses.*.state' => 'required',
        'addresses.*.city' => 'required',
    ];

}