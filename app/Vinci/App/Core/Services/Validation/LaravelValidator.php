<?php

namespace Vinci\App\Core\Services\Validation;

use Illuminate\Contracts\Validation\Factory;

abstract class LaravelValidator extends AbstractValidator
{

    protected $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function passes($action = null)
    {
        $rules = $this->getRules($action);
        $messages = $this->getMessages();
        $attributes = $this->getAttributes();
        $validator = $this->validator->make($this->data, $rules, $messages, $attributes);

        if($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

}