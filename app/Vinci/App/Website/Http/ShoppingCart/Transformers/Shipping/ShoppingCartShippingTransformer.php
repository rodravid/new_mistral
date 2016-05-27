<?php

namespace Vinci\App\Website\Http\ShoppingCart\Transformers\Shipping;

use League\Fractal\TransformerAbstract;

class ShoppingCartShippingTransformer extends TransformerAbstract
{

    public function transform($shipping)
    {
        if (! empty($shipping)) {

            return [
                'price' => $shipping->getPrice(),
                'deadline' => $shipping->getDeadline()
            ];

        }

        return [];
    }

}