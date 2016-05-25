<?php

namespace Vinci\App\Website\Http\ShoppingCart\Transformers\Item;

use League\Fractal\TransformerAbstract;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

class ShoppingCartItemTransformer extends TransformerAbstract
{

    public function transform(ShoppingCartItem $item)
    {
        $data = [
            'id' => $item->getId(),
            'name' => $item->getTitle(),
            'sale_price' => $item->getSalePrice(),
            'quantity' => $item->getQuantity(),
            'subtotal' => $item->getSubTotal()
        ];

        if ($item->hasProducer()) {
            $data['producer'] = $item->getProducer()->getName();
        }

        return $data;
    }

}