<?php

namespace Vinci\App\Website\Http\ShoppingCart\Provider;

use Illuminate\Contracts\Auth\Factory as AuthManager;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider as ShoppingCartProviderInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class CustomerShoppingCartProvider implements ShoppingCartProviderInterface
{
    protected $cartProvider;

    protected $auth;

    public function __construct(
        ShoppingCartProviderInterface $cartProvider,
        AuthManager $auth
    ) {
        $this->cartProvider = $cartProvider;
        $this->auth = $auth;
    }

    public function getShoppingCart()
    {
        if ($this->auth->guard('website')->check()) {

            $customer = $this->auth->guard('website')->user();

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