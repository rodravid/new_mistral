<?php

namespace Vinci\Domain\Order;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class OrderValidator extends LaravelValidator
{

    protected $rules = [
        'shipping.address' => 'required',
        'payment.method' => 'required',
        'payment.installments' => 'required',
        'card.holdername' => 'required',
        'card.number' => 'required',
        'document' => 'required',
        'card.expiry_month' => 'required',
        'card.expiry_year' => 'required',
        'card.security_code' => 'required',
    ];

    protected $messages = [
        'document.required' => 'Informe o CPF/CNPJ do titular do cartão.',
        'card.holdername.required' => 'Informe o nome impresso no cartão.',
        'card.number.required' => 'Informe o número do cartão.',
        'card.expiry_month.required' => 'Selecione o mês de validade do cartão.',
        'card.expiry_year.required' => 'Selecione o ano de validade do cartão.',
        'card.security_code.required' => 'Informe o código de segurança do cartão.',
        'payment.method.required' => 'Selecione uma forma de pagamento.'
    ];

}