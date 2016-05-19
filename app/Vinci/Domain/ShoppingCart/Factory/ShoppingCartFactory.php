<?php

namespace Vinci\Domain\ShoppingCart\Factory;

use Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory as ShoppingCartFactoryInterface;
use Vinci\Domain\ShoppingCart\ShoppingCart;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartFactory implements ShoppingCartFactoryInterface
{

    public function createNew(array $params = [])
    {
        $cart = new ShoppingCart;

        $this->attachCustomer($cart, $params);

        return $cart;
    }

    protected function attachCustomer(ShoppingCartInterface $cart, array $params)
    {
        if (isset($params['customer'])) {
            $cart->setCustomer($params['customer']);
        }
    }

}