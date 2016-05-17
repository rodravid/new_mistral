<?php

namespace Vinci\Domain\ShoppingCart\Services;

use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;

class ShoppingCartService
{

    protected $cartRepository;

    private $cartProvider;

    public function __construct(ShoppingCartRepository $cartRepository, ShoppingCartProvider $cartProvider)
    {
        $this->cartRepository = $cartRepository;
        $this->cartProvider = $cartProvider;
    }

    public function getCart()
    {
        return $this->cartProvider->getShoppingCart();
    }

}