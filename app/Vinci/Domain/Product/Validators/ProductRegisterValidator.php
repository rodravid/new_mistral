<?php
/**
 * Created by PhpStorm.
 * User: webeleven
 * Date: 20/06/16
 * Time: 11:24
 */

namespace Vinci\Domain\Product\Validators;


use Vinci\App\Core\Services\Validation\LaravelValidator;

class ProductRegisterValidator extends LaravelValidator
{
    protected $rules = [
        'email' => 'required|email',
        'productId' => 'exists:Vinci\Domain\Product\Product,id'
    ];

    protected $messages = [
        'productId.exists' => 'Não foi possível adicionar seu contato para este produto'
    ];
}