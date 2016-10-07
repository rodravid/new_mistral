<?php

namespace Vinci\Domain\Dollar;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class DollarValidator extends LaravelValidator
{

    protected $rules = [
        'description' => 'required',
        'amount' => 'required|numeric',
        'startsAt' => 'required|date_format:d/m/Y H:i',
    ];

    protected $messages = [
        'amount.required' => 'O campo Valor do dólar é obrigatório.',
        'amount.numeric' => 'O campo Valor do dólar deve conter um valor numérico.',
        'startsAt.required' => 'É necessário selecionar a data de inicío da publicação.',
        'startsAt.date_format' => 'Data de início da publicação inválida.'
    ];

}