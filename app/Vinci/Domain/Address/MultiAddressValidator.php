<?php

namespace Vinci\Domain\Address;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class MultiAddressValidator extends LaravelValidator
{

    protected $rules = [
        'addresses.*.type' => 'required',
        'addresses.*.postal_code' => 'required|min:8|max:9',
        'addresses.*.nickname' => 'required_if:addresses.*.type,3',
        'addresses.*.public_place' => 'required|exists:Vinci\Domain\Address\PublicPlace,id',
        'addresses.*.address' => 'required',
        'addresses.*.number' => 'required|max:10',
        'addresses.*.district' => 'required',
        'addresses.*.country' => 'required|exists:Vinci\Domain\Address\Country\Country,id',
        'addresses.*.state' => 'required|exists:Vinci\Domain\Address\State\State,id',
        'addresses.*.city' => 'required|exists:Vinci\Domain\Address\City\City,id',
    ];

}