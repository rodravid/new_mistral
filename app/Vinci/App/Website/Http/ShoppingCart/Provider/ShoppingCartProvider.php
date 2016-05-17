<?php

namespace Vinci\App\Website\Http\ShoppingCart\Provider;

use Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext;
use Vinci\Domain\ShoppingCart\Factory\Contracts\ShoppingCartFactory;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider as ShoppingCartProviderInterface;

class ShoppingCartProvider implements ShoppingCartProviderInterface
{

    protected $cartContext;

    protected $cartRepository;

    protected $cartFactory;

    public function __construct(
        ShoppingCartContext $cartContext,
        ShoppingCartRepository $cartRepository,
        ShoppingCartFactory $cartFactory
    ) {
        $this->cartContext = $cartContext;
        $this->cartRepository = $cartRepository;
        $this->cartFactory = $cartFactory;
    }

    public function getShoppingCart()
    {
        return $this->provideCart();
    }

    private function provideCart()
    {
        $cartIdentifier = $this->cartContext->getCurrentCartIdentifier();

        if ($cartIdentifier !== null) {

            $cart = $this->cartRepository->find($cartIdentifier);

            if ($cart !== null) {
                return $cart;
            }
        }

        $cart = $this->cartFactory->createNew();

        $this->cartContext->setCurrentCartIdentifier($cart);

        return $cart;
    }

    public function hasShoppingCart()
    {
        return (bool) $this->cartContext->getCurrentCartIdentifier();
    }
}