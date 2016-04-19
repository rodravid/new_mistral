<?php

namespace Vinci\Domain\Deadline;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class DeadlineValidator extends LaravelValidator
{

    protected $rules = [
        'description' => 'required',
        'days' => 'required|integer|min:0',
    ];

    protected $messages = [
        'days.required' => 'O campo Prazo de entrega em dias é obrigatório.',
        'days.integer' => 'O campo Prazo de entrega deve conter um valor inteiro.',
        'days.min' => 'O campo Prazo de entrega nao pode conter um valor negativo.'
    ];

}