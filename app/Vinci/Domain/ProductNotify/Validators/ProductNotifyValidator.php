<?php

namespace Vinci\Domain\ProductNotify\Validators;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class ProductNotifyValidator extends LaravelValidator
{
    protected $rules = [
        'customer_email' => 'required|email',
        'product' => 'exists:Vinci\Domain\Product\Product,id'
    ];

    protected $messages = [
        'product.exists' => 'Não foi possível adicionar seu contato para este produto.',
        'customer_email.required' => 'O campo acima é obrigatório.',
        'customer_email.email' => 'O campo acima deve conter um endereço de email válido.'
    ];
}