<?php

namespace Vinci\Domain\ShoppingCart\Facades;

use Illuminate\Support\Facades\Facade;

class ShoppingCart extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'shoppingcart';
    }

}