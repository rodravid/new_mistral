<?php

namespace Vinci\App\Core\Validators;

use Illuminate\Validation\Factory;

abstract class LaravelValidator
{

    protected $factory;

    protected $errors;

    protected $rules;

    protected $messages = [];

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function fails(array $input, $ignoreId = null)
    {
        $validator = $this->factory->make($input, $this->getRules($ignoreId), $this->messages);
        $result = $validator->fails($input);
        $this->errors = $validator->messages();
        return $result;
    }

    public function messages()
    {
        return $this->errors;
    }

    protected function getRules($ignoreId = null)
    {
        $rules = $this->rules;

        if (! empty($ignoreId)) {
            $rules = $this->assignIdOnUniqueRules($ignoreId, $rules);
        }

        return $rules;
    }

    private function assignIdOnUniqueRules($id, $rules)
    {
        foreach ($rules as $key => $rule) {
            if (strpos($rule, 'unique:') !== false) {
                $rules[$key] .= ",{$id}";
            }
        }

        return $rules;
    }


}