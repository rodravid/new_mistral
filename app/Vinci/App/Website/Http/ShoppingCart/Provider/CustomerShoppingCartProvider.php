<?php

namespace Vinci\App\Website\Http\ShoppingCart\Provider;

use Illuminate\Contracts\Auth\Guard;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider as ShoppingCartProviderInterface;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class CustomerShoppingCartProvider implements ShoppingCartProviderInterface
{
    protected $cartProvider;

    private $cartRepository;

    protected $auth;

    public function __construct(
        ShoppingCartProviderInterface $cartProvider,
        ShoppingCartRepository $cartRepository,
        Guard $auth
    ) {
        $this->cartProvider = $cartProvider;
        $this->cartRepository = $cartRepository;
        $this->auth = $auth;
    }

    public function getShoppingCart()
    {
        if ($this->auth->check()) {

            $customer = $this->auth->user();

            $cart = $this->cartRepository->getLastByCustomer($customer);

            if ($cart) {

                $this->setShoppingCart($cart);

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