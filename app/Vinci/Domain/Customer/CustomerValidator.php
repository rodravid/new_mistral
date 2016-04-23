<?php

namespace Vinci\Domain\Customer;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class CustomerValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:Vinci\Domain\Customer\Customer,email',
        'customerType' => 'required',
        'gender' => 'required_if:customerType,1',
        'birthday' => 'required_if:customerType,1|date_format:d/m/Y',
        'cpf' => 'required_if:customerType,1',
        'rg' => 'required_if:customerType,1',
        'companyName' => 'required_if:customerType,2',
        'companyContact' => 'required_if:customerType,2',
        'cnpj' => 'required_if:customerType,2',
        'stateRegistration' => 'required_if:customerType,2',
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
        'password.required_without' => 'O campo senha é obrigatório.',
        'gender.required_if' => 'Selecione o sexo.',
        'birthday.required_if' => 'Informe a data de nascimento.',
        'cpf.required_if' => 'O campo CPF é obrigatório.',
        'rg.required_if' => 'O campo RG é obrigatório.',
        'companyName.required_if' => 'O campo Nome da empresa é obrigatório.',
        'companyContact.required_if' => 'O campo Responsável é obrigatório.',
        'cnpj.required_if' => 'O campo CNPJ é obrigatório.',
        'stateRegistration.required_if' => 'O campo Inscrição estadual é obrigatório.',
    ];

}