<?php

namespace Vinci\App\Website\Auth\Events\Listeners;

use Illuminate\Auth\Events\Login;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Domain\ShoppingCart\ShoppingCart;

class LinkCustomerToCurrentCart
{

    private $cartProvider;

    private $cartRepository;

    public function __construct(ShoppingCartProvider $cartProvider, ShoppingCartRepository $cartRepository)
    {
        $this->cartProvider = $cartProvider;
        $this->cartRepository = $cartRepository;
    }

    public function handle(Login $event)
    {
        $user = $event->user;

        if ($user->isCustomer()) {
            $this->linkCustomerToCurrentCart($user);
        }
    }

    private function linkCustomerToCurrentCart(Customer $customer)
    {
        $currentCart = $this->cartProvider->getShoppingCart();

        if ($this->shouldBeLinked($currentCart)) {

            $currentCart->setCustomer($customer);
            $this->cartRepository->save($currentCart);

            return true;
        }
    }

    protected function shouldBeLinked(ShoppingCart $cart)
    {
        return $cart->hasItems();
    }

}