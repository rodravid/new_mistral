<?php

namespace Vinci\App\Website\Http\Order\Transformers;

use League\Fractal\TransformerAbstract;

class TransactionProductsTagTransformer extends TransformerAbstract
{

    public function transform($order)
    {
        $products = [];

        foreach ($order->getItems() as $item) {

            $variant = $item->getProductVariant();
            $product = $variant->getProduct();

            $products[] = [
                'sku' => $variant->getSku(),
                'name' => $variant->getTitle(),
                'brand' => $product->getProducer()->getName(),
                'category' => sprintf('%s > %s > %s', $product->country->name, $product->region->name, $product->producer->name),
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity()
            ];

        }

        return $products;
    }

}