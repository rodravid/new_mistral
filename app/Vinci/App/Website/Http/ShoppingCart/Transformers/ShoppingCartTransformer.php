<?php

namespace Vinci\App\Website\Http\ShoppingCart\Transformers;

use League\Fractal\TransformerAbstract;
use Vinci\App\Website\Http\ShoppingCart\Transformers\Item\ShoppingCartItemTransformer;
use Vinci\App\Website\Http\ShoppingCart\Transformers\Shipping\ShoppingCartShippingTransformer;
use Vinci\Domain\Order\Item\ValidItemsFilter;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'items',
        'shipping'
    ];

    public function transform(ShoppingCartInterface $shoppingCart)
    {
        return [
            'id' => (string) $shoppingCart->getId(),
            'subtotal' => $shoppingCart->getSubtotal(),
            'total' => $shoppingCart->getTotal(),
            'count_items' => $shoppingCart->countItems(),
            'count_products' => $shoppingCart->getItems()->count(),
            'valid_items_count' => app(ValidItemsFilter::class)->filter($shoppingCart->getItems())->count()
        ];
    }

    public function includeItems(ShoppingCartInterface $shoppingCart)
    {
        $items = $shoppingCart->getItems();

        return $this->collection($items, new ShoppingCartItemTransformer);
    }

    public function includeShipping(ShoppingCartInterface $shoppingCart)
    {
        $shipping = $shoppingCart->getShipping();

        return $this->item($shipping, new ShoppingCartShippingTransformer);
    }

}