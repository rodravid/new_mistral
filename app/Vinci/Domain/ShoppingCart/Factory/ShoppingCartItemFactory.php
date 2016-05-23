<?php

namespace Vinci\Domain\ShoppingCart\Factory;

use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

class ShoppingCartItemFactory
{

    public function make(array $data)
    {
        $item = new ShoppingCartItem;

        $item->setQuantity(array_get($data, 'quantity', 0));

        if (isset($data['variant']) && ! empty($variant = $data['variant'])) {
            $item->setProductVariant($variant);
        }

        return $item;
    }

}