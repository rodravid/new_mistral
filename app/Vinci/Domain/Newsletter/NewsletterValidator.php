<?php
namespace Vinci\Domain\Newsletter;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class NewsletterValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:Vinci\Domain\Newsletter\Newsletter,email',
    ];

    protected $messages = [
        'email.unique' => 'Endereço de email já cadastrado'
    ];

}