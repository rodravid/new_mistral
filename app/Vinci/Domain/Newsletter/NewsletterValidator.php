<?php

namespace Vinci\Domain\Admin;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class NewsletterValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];

}