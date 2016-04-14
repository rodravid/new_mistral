<?php

namespace Vinci\Domain\Highlight;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class HighlightValidator extends LaravelValidator
{

    protected $rules = [
        'title' => 'required',
    ];

}