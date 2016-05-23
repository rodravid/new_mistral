<?php

namespace Vinci\App\Website\Http\Checkout\Payment\Request;

use Vinci\App\Core\Http\Requests\Request;

class PaymentRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'address_id' => 'required',
        ];
    }

    protected $messages = [
        'address_id.required' => 'Você deve selecionar um endereço de entrega'
    ];

}