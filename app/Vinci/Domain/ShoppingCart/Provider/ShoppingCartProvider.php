<?php

namespace Vinci\Domain\ShoppingCart\Provider;

interface ShoppingCartProvider
{

    public function hasShoppingCart();

    public function getShoppingCart();

}