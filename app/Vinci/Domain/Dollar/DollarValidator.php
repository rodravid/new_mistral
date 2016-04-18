<?php

namespace Vinci\Domain\Dollar;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class DollarValidator extends LaravelValidator
{

    protected $rules = [
        'description' => 'required',
        'amount' => 'required|numeric',
    ];

    protected $messages = [
        'amount.required' => 'O campo Valor do dólar é obrigatório.',
        'amount.numeric' => 'O campo Valor do dólar deve conter um valor numérico.'
    ];

}