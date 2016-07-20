<?php

namespace Vinci\Domain\ERP\Order\Item;

use Vinci\Domain\ERP\Transformer\BaseTransformer;
use Vinci\Domain\Order\Item\OrderItem;

class ItemTransformer extends BaseTransformer
{

    public function transform(OrderItem $item)
    {
        return [
            'id' => $item->getId(),
            'order_number' => $item->getOrder()->getErpNumber(),
            'sku' => $item->getProductVariant()->getSku(),
            'quantity' => $item->getQuantity(),
            'price' => $item->getPrice(),
            'discount' => '',
            'discount_percent' => 0
        ];
    }

}