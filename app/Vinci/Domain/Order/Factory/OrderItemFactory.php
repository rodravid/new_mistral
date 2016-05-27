<?php

namespace Vinci\Domain\Order\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItemInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class OrderItemFactory
{

    public function make(array $data = [])
    {
        $item = $this->getNewInstance();

        $item
            ->setProductVariant(array_get($data, 'product_variant'))
            ->setPrice(array_get($data, 'price'))
            ->setOriginalPrice(array_get($data, 'original_price'))
            ->setQuantity(array_get($data, 'quantity'))
            ->setTotal(array_get($data, 'price') * array_get($data, 'quantity'));

        return $item;
    }

    public function makeCollection(array $items)
    {

    }

    public function makeFromShoppingCartItem(ShoppingCartItemInterface $cartItem)
    {
        $data = [
            'product_variant' => $cartItem->getProductVariant(),
            'price' => $cartItem->getSalePrice(),
            'original_price' => $cartItem->getOriginalSalePrice(),
            'quantity' => $cartItem->getQuantity(),
            'total' => $cartItem->getSubtotal()
        ];

        return $this->make($data);
    }

    public function makeFromShoppingCart(ShoppingCartInterface $shoppingCart)
    {
        $orderItems = new ArrayCollection;

        foreach ($shoppingCart->getItems() as $item) {
            $orderItems->add($this->makeFromShoppingCartItem($item));
        }

        return $orderItems;
    }

    protected function getNewInstance()
    {
        return new OrderItem;
    }

}