<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'A confirmação do campo :attribute não confere.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'O campo :attribute deve conter um endereço de e-mail válido.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'O campo :attribute deve conter um número inteiro.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'O campo :attribute deve ser maior ou igual :min.',
        'file'    => 'O campo :attribute deve conter um arquivo de no mínimo :min kilobytes.',
        'string'  => 'O campo :attribute deve conter no mínimo :min caracteres.',
        'array'   => 'O campo :attribute deve conter no mínimo :min itens.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',
    'unique_user'          => 'O endereço de e-mail informado já está sendo utilizado.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'roles' => [
            'required' => 'Você deve selecionar um grupo para o usuário.',
        ],
        'addresses.*.postal_code' => [
            'required' => 'O campo CEP é obrigatório para cada endereço.'
        ],
        'addresses.*.nickname' => [
            'required' => 'O campo Apelido é obrigatório para cada endereço.'
        ],
        'addresses.*.public_place' => [
            'required' => 'O campo Tipo é obrigatório para cada endereço.'
        ],
        'addresses.*.address' => [
            'required' => 'O campo Logradouro é obrigatório para cada endereço.'
        ],
        'addresses.*.number' => [
            'required' => 'O campo Número é obrigatório para cada endereço.'
        ],
        'addresses.*.district' => [
            'required' => 'O campo Bairro é obrigatório para cada endereço.'
        ],
        'addresses.*.country' => [
            'required' => 'O campo País é obrigatório para cada endereço.'
        ],
        'addresses.*.state' => [
            'required' => 'O campo Estado é obrigatório para cada endereço.'
        ],
        'addresses.*.city' => [
            'required' => 'O campo Cidade é obrigatório para cada endereço.'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Nome',
        'email' => 'E-mail',
        'title' => 'Título',
        'subtitle' => 'Subtítulo',
        'description' => 'Descrição',
        'url' => 'URL',
        'amount' => 'Valor',
        'password' => 'Senha',
        'password_confirmation' => 'Confirmação de Senha',
        'roles' => 'Grupo',
        'position' => 'Ordem'
    ],

];
