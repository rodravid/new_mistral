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
        'product.exists' => 'Não foi possível adicionar seu contato para este produto'
    ];
}