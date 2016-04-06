<?php

namespace Vinci\Domain\Admin;

use Vinci\App\Core\Validators\LaravelValidator;

class AdminValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:Vinci\Domain\Admin\Admin,email',
        'password' => 'required_without:id|min:6|confirmed',
        'roles'  => 'required'
    ];

    protected $messages = [
        'email.unique' => 'Esse endereço de e-mail já está sendo utilizado por outro usuário.',
        'password.required_without' => 'O campo senha é obrigatório'
    ];

}