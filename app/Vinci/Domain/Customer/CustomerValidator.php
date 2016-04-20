<?php

namespace Vinci\Domain\Customer;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class CustomerValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:Vinci\Domain\Customer\Customer,email',
        'office' => 'max:255',
        'password' => 'required_without:id|min:6|confirmed'
    ];

    protected $messages = [
        'email.unique' => 'Esse endereço de e-mail já está sendo utilizado por outro usuário.',
        'password.required_without' => 'O campo senha é obrigatório'
    ];

}