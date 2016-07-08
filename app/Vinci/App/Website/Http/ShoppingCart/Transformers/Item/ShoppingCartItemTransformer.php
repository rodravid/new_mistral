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
            'name' => $item->getProduct()->present()->title,
            'sale_price' => $item->getSalePrice(),
            'quantity' => $item->getQuantity(),
            'subtotal' => $item->getSubTotal(),
            'image_url' => $item->getProduct()->present()->image_url,
            'web_path' => $item->getProduct()->getWebPath(),
            'is_available' => $item->getProduct()->isGiftPackage(),
            'is_stock_available' => $item->getProduct()->hasStock(),
            'is_gift_package' => $item->getProduct()->isGiftPackage()
        ];

        if ($item->hasProducer()) {
            $data['producer'] = $item->getProducer()->getName();
        }

        return $data;
    }

}