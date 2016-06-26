<?php

namespace Vinci\Domain\Promotion\Types\Shipping;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class ShippingPromotionValidator extends LaravelValidator
{

    protected $rules = [
        'deliveryTracks' => 'required',
        'title' => 'required',
        'initialAmount' => 'required|numeric',
        'finalAmount' => 'numeric',
        'discountType' => 'required',
        'discountAmount' => 'required|numeric',
        'startsAt' => 'required|date_format:d/m/Y H:i',
        'expirationAt' => 'date_format:d/m/Y H:i'
    ];

    protected $messages = [
        'startsAt.required' => 'É necessário selecionar a data de inicío da publicação.',
        'startsAt.date_format' => 'Data de início da publicação inválida.',
        'expirationAt.date_format' => 'Data de expiração inválida.',
        'discountAmount.required' => 'O valor do desconto é obrigatório.',
        'discountAmount.numeric' => 'O valor do desconto deve ser numérico.',
        'initialAmount.required' => 'O valor inicial da compra é obrigatório.',
        'initialAmount.numeric' => 'O valor inicial da compra deve ser númerico.',
        'finalAmount.numeric' => 'O valor final da compra deve ser númerico.',
        'deliveryTracks.required' => 'Selecione ao menos uma região para aplicar o desconto.',
    ];

}