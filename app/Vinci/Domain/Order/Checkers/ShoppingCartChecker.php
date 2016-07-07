<?php

namespace Vinci\Domain\Order\Checkers;

use Vinci\Domain\Order\Item\ValidItemsFilter;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartChecker
{

    private $itemsFilter;

    public function __construct(ValidItemsFilter $itemsFilter)
    {
        $this->itemsFilter = $itemsFilter;
    }

    public function canBeOrdered(ShoppingCartInterface $shoppingCart)
    {
        $validItems = $this->itemsFilter->filter($shoppingCart->getItems());

        return $validItems->count() > 0;
    }

}