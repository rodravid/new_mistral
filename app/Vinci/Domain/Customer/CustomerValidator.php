<?php

namespace Vinci\Domain\Customer;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class CustomerValidator extends LaravelValidator
{

    protected $rules = [
        'customerType' => 'required',
        'email' => 'required|email|unique:Vinci\Domain\Customer\Customer,email',
        'name' => 'required_if:customerType,1',
        'gender' => 'required_if:customerType,1',
        'birthday' => 'required_if:customerType,1|date_format:d/m/Y|after:1915-01-01|before:-18 years',
        'cpf' => 'required_if:customerType,1|cpf|unique:Vinci\Domain\Customer\Customer,cpf',
        'rg' => 'min:6|max:12',
        'companyName' => 'required_if:customerType,2',
        'cnpj' => 'required_if:customerType,2|cnpj|unique:Vinci\Domain\Customer\Customer,cnpj',
        'stateRegistration' => 'required_if:customerType,2',
        'main_address' => 'required_with:addresses',
        'cellPhone' => 'required_without:phone|min:10|max:11',
        'phone' => 'required_without:cellPhone|min:10|max:11',
        'password' => 'required_without:id|min:6|confirmed'
    ];

    protected $messages = [
        'name.required_if' => 'O campo Nome é obrigatório.',
        'customerType.required' => 'Selecione o tipo de pessoa.',
        'email.unique' => 'O endereço de e-mail informado já está sendo utilizado por outro usuário.',
        'cpf.unique' => 'O CPF informado já está sendo utilizado por outro usuário.',
        'cnpj.unique' => 'O CNPJ informado já está sendo utilizado por outro usuário.',
        'password.required_without' => 'O campo senha é obrigatório.',
        'gender.required_if' => 'Selecione o sexo.',
        'birthday.required_if' => 'Informe a data de nascimento.',
        'birthday.after' => 'Data de nascimento inválida.',
        'birthday.before' => 'Segundo o art. 81, II da Lei nº 8.069/90, menores de 18 anos não podem comprar bebida alcoólica.',
        'cpf.required_if' => 'O campo CPF é obrigatório.',
        'cpf.cpf' => 'CPF inválido.',
        'rg.min' => 'O campo RG deve conter no mínimo :min caracteres.',
        'rg.max' => 'O campo RG deve conter no máximo :max caracteres.',
        'rg.required_if' => 'O campo RG é obrigatório.',
        'companyName.required_if' => 'O campo Nome da empresa é obrigatório.',
        'companyContact.required_if' => 'O campo Responsável é obrigatório.',
        'cnpj.required_if' => 'O campo CNPJ é obrigatório.',
        'cnpj.cnpj' => 'CNPJ inválido.',
        'stateRegistration.required_if' => 'O campo Inscrição estadual é obrigatório.',
        'main_address.required_with' => 'É necessário informar qual é o endereço principal.',
        'cellPhone.required_without' => 'Informe um número de telefone.',
        'phone.required_without' => 'Informe um número de telefone.',
    ];

}