<?php

namespace Vinci\App\Website\Http\ShoppingCart\Transformers;

use League\Fractal\TransformerAbstract;
use Vinci\App\Website\Http\ShoppingCart\Transformers\Item\ShoppingCartItemTransformer;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'items'
    ];

    public function transform(ShoppingCartInterface $shoppingCart)
    {
        return [
            'id' => (string) $shoppingCart->getId()
        ];
    }

    public function includeItems(ShoppingCartInterface $shoppingCart)
    {
        $items = $shoppingCart->getItems();

        return $this->collection($items, new ShoppingCartItemTransformer);
    }

}