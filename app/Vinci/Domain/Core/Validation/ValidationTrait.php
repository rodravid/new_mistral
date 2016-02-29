<?php

namespace Vinci\Domain\Core\Validation;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

trait ValidationTrait
{
    protected $validatesRequestErrorBag;

    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($validator);
        }
    }

    protected function throwValidationException($validator)
    {
        throw new ValidationException($validator);
    }

    protected function getValidationFactory()
    {
        return app(Factory::class);
    }
}
