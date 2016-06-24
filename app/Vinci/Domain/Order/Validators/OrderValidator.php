<?php

namespace Vinci\Domain\Order\Validators;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class OrderValidator extends LaravelValidator
{

    protected $rules = [
        'shipping.address' => 'required',
        'payment.method' => 'required',
        'payment.installments' => 'requiredif:payment.method_type,credit_card',
    ];

    protected $messages = [
        'payment.method.required' => 'Selecione uma forma de pagamento.'
    ];

}