<?php

namespace Vinci\Domain\Customer;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class CustomerValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:Vinci\Domain\Customer\Customer,email',
        'password' => 'required_without:id|min:6|confirmed',
        'addresses.*.postal_code' => 'required',
        'addresses.*.public_place' => 'required',
        'addresses.*.address' => 'required',
        'addresses.*.number' => 'required',
        'addresses.*.district' => 'required',
        'addresses.*.country' => 'required',
        'addresses.*.state' => 'required',
        'addresses.*.city' => 'required',
    ];

    protected $messages = [
        'email.unique' => 'Esse endereço de e-mail já está sendo utilizado por outro usuário.',
        'password.required_without' => 'O campo senha é obrigatório'
    ];

}