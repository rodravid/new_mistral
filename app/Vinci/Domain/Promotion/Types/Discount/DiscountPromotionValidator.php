<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class DiscountPromotionValidator extends LaravelValidator
{

    protected $rules = [
        'title' => 'required',
        'discountType' => 'required',
        'discountAmount' => 'required',
        'startsAt' => 'required|date_format:d/m/Y H:i',
        'expirationAt' => 'date_format:d/m/Y H:i'
    ];

    protected $messages = [
        'startsAt.required' => 'É necessário selecionar a data de inicío da publicação.',
        'startsAt.date_format' => 'Data de início da publicação inválida.',
        'expirationAt.date_format' => 'Data de expiração inválida.',
    ];

}