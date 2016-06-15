<?php
namespace Vinci\App\Website\Http\Contact;


use Vinci\App\Core\Services\Validation\LaravelValidator;

class ContactValidator extends LaravelValidator
{
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
    ];

    protected $messages = [
        'subject.required' => 'O campo assunto é obrigatório',
        'message.required' => 'O campos mensagem é obrigatório'
    ];
    
}