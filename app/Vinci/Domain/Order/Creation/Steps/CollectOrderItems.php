<?php

namespace Vinci\Domain\Order\Creation\Steps;

use Vinci\Domain\Order\Factory\OrderItemFactory;
use Vinci\Domain\Order\Item\ValidItemsFilter;
use Vinci\Domain\ShoppingCart\Exceptions\InvalidShoppingCartException;

class CollectOrderItems
{
    private $factory;

    public function __construct(OrderItemFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle($data, $next)
    {
        $order = $data['order'];

        $shoppingCart = $this->getShoppingCart($data);

        $items = $this->factory->makeFromShoppingCart($shoppingCart);

        $items = (new ValidItemsFilter())->filter($items);

        if (! $items->count()) {
            throw new InvalidShoppingCartException('The shopping cart given does not contains valid items.');
        }

        $order->setItems($items);
        $order->setShoppingCart($shoppingCart);

        return $next($data);
    }

    protected function getShoppingCart(array $data)
    {
        return array_get($data, 'cart');
    }

}