<?php

namespace Vinci\Domain\Payment\Validators;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class CreditCardValidator extends LaravelValidator
{
    protected $rules = [
        'payment.installments' => 'required_if:payment.method_type,credit_card',
        'payment.method_type' => 'exists:Vinci\Domain\Payment\PaymentMethod,description',
        'card.holdername' => 'required_if:payment.method_type,==,credit_card',
        'card.number' => 'required_if:payment.method_type,==,credit_card',
        'document' => 'required_if:payment.method_type,==,credit_card|cpf_cnpj',
        'card.expiry_month' => 'required_if:payment.method_type,==,credit_card',
        'card.expiry_year' => 'required_if:payment.method_type,==,credit_card',
        'card.security_code' => 'required_if:payment.method_type,==,credit_card|digits_between:3,4',
    ];

    protected $messages = [
        'document.required_if' => 'Informe o CPF/CNPJ do titular do cartão.',
        'document.cpf_cnpj' => 'CPF/CNPJ inválido.',
        'card.holdername.required_if' => 'Informe o nome impresso no cartão.',
        'card.number.required_if' => 'Informe o número do cartão.',
        'card.expiry_month.required_if' => 'Selecione o mês de validade do cartão.',
        'card.expiry_year.required_if' => 'Selecione o ano de validade do cartão.',
        'card.security_code.required_if' => 'Informe o código de segurança do cartão.',
        'card.security_code.size' => 'Código de segurança do cartão neccesita ter 3 dígitos.',
        'card.security_code.digits_between' => 'O código de segurança deve conter no mínimo 3 dígitos.',
        'payment.installments.required_if' => 'Selecione o parcelamento.'
    ];
}