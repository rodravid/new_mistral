<?php

namespace Vinci\Domain\ShoppingCart\Context\Contracts;

use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

interface ShoppingCartContext
{

    const STORAGE_KEY = '_webeleven_cart_id';

    /**
     * Get the currently active cart.
     *
     * @return string
     */
    public function getCurrentCartIdentifier();

    /**
     * Set the currently active cart.
     *
     * @param ShoppingCartInterface $shoppingCart
     */
    public function setCurrentCartIdentifier(ShoppingCartInterface $shoppingCart);

    /**
     * Resets current cart identifier.
     * Basically, it means abandoning current cart.
     */
    public function resetCurrentCartIdentifier();

}