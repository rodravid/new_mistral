<?php

namespace Vinci\Domain\ShoppingCart\Factory;

use Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory as ShoppingCartFactoryInterface;
use Vinci\Domain\ShoppingCart\ShoppingCart;

class ShoppingCartFactory implements ShoppingCartFactoryInterface
{

    public function createNew()
    {
        return new ShoppingCart;
    }
}