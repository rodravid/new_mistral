<?php

namespace Vinci\Domain\Order;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class OrderValidator extends LaravelValidator
{

    protected $rules = [
        'shipping.address' => 'required',
        'payment.method' => 'required',
        'payment.installments' => 'requiredif:payment.method_type,credit_card',
        'payment.method_type' => 'exists:Vinci\Domain\Payment\PaymentMethod,description',
        'card.holdername' => 'requiredif:payment.method_type,credit_card',
        'card.number' => 'requiredif:payment.method_type,credit_card',
        'document' => 'requiredif:payment.method_type,credit_card',
        'card.expiry_month' => 'requiredif:payment.method_type,credit_card',
        'card.expiry_year' => 'requiredif:payment.method_type,credit_card',
        'card.security_code' => 'requiredif:payment.method_type,credit_card',
    ];

    protected $messages = [
        'document.requiredif' => 'Informe o CPF/CNPJ do titular do cartão.',
        'card.holdername.requiredif' => 'Informe o nome impresso no cartão.',
        'card.number.requiredif' => 'Informe o número do cartão.',
        'card.expiry_month.requiredif' => 'Selecione o mês de validade do cartão.',
        'card.expiry_year.requiredif' => 'Selecione o ano de validade do cartão.',
        'card.security_code.requiredif' => 'Informe o código de segurança do cartão.',
        'payment.method.required' => 'Selecione uma forma de pagamento.'
    ];

}