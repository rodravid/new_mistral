<?php

namespace Vinci\App\Website\Http\ShoppingCart\Transformers\Item;

use League\Fractal\TransformerAbstract;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

class ShoppingCartItemTransformer extends TransformerAbstract
{

    public function transform(ShoppingCartItem $item)
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getTitle(),
            'producer' => 'Catena Zapata',
            'sale_price' => $item->getSalePrice(),
            'quantity' => $item->getQuantity(),
            'subtotal' => $item->getSubTotal()
        ];
    }

}