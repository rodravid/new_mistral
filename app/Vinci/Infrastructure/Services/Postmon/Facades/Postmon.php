<?php

namespace Vinci\Infrastructure\Services\Postmon\Facades;

use Illuminate\Support\Facades\Facade;

class Postmon extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'postmon';
    }

}