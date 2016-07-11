<?php

namespace Vinci\App\Website\Http\ShoppingCart\Provider;

use Illuminate\Contracts\Auth\Guard;
use Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext;
use Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider as ShoppingCartProviderInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartProvider implements ShoppingCartProviderInterface
{

    protected $cartContext;

    protected $cartRepository;

    protected $cartFactory;

    protected $currentCart;

    protected $auth;

    public function __construct(
        ShoppingCartContext $cartContext,
        ShoppingCartRepository $cartRepository,
        ShoppingCartFactory $cartFactory,
        Guard $auth
    ) {
        $this->cartContext = $cartContext;
        $this->cartRepository = $cartRepository;
        $this->cartFactory = $cartFactory;
        $this->auth = $auth;
    }

    public function getShoppingCart()
    {
        if (! $this->currentCart) {

            $cart = $this->provideCart();

            $this->setShoppingCart($cart);

            return $cart;
        }

        return $this->currentCart;
    }

    private function provideCart()
    {
        $cartIdentifier = $this->cartContext->getCurrentCartIdentifier();

        if ($cartIdentifier !== null) {

            $cart = $this->cartRepository->find($cartIdentifier);

            if ($cart !== null && ! $cart->hasCustomer()) {
                return $cart;
            }

        }

        return $this->cartFactory->createNew(['customer' => $this->auth->user()]);
    }

    public function setShoppingCart(ShoppingCartInterface $shoppingCart)
    {
        $this->currentCart = $shoppingCart;
        $this->cartContext->setCurrentCartIdentifier($shoppingCart);
    }
}