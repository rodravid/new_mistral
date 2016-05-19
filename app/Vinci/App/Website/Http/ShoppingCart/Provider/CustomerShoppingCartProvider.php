<?php

namespace Vinci\App\Website\Http\ShoppingCart\Provider;

use Illuminate\Contracts\Auth\Guard;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider as ShoppingCartProviderInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class CustomerShoppingCartProvider implements ShoppingCartProviderInterface
{
    protected $cartProvider;

    protected $auth;

    public function __construct(
        ShoppingCartProviderInterface $cartProvider,
        Guard $auth
    ) {
        $this->cartProvider = $cartProvider;
        $this->auth = $auth;
    }

    public function getShoppingCart()
    {
        if ($this->auth->check()) {

            $customer = $this->auth->user();

            $cart = $customer->getLastShoppingCart();

            if ($cart) {
                return $cart;
            }
        }

        return $this->cartProvider->getShoppingCart();
    }

    public function setShoppingCart(ShoppingCartInterface $shoppingCart)
    {
        $this->cartProvider->setShoppingCart($shoppingCart);
    }
}