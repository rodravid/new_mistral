<?php

namespace Vinci\Domain\ShoppingCart\Resolver;


use Vinci\Domain\Inventory\Checkers\Contracts\AvailabilityChecker;
use Vinci\Domain\Inventory\Contracts\Stockable;
use Vinci\Domain\Inventory\Exceptions\InsufficientStockException;
use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\ShoppingCart\Factory\ShoppingCartItemFactory;
use Vinci\Domain\ShoppingCart\Resolver\Contracts\ItemResolver as ItemResolverInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ItemResolver implements ItemResolverInterface
{

    protected $availabilityChecker;

    protected $itemFactory;

    public function __construct(AvailabilityChecker $availabilityChecker, ShoppingCartItemFactory $itemFactory)
    {
        $this->availabilityChecker = $availabilityChecker;
        $this->itemFactory = $itemFactory;
    }

    public function resolve(ShoppingCartInterface $shoppingCart, ProductVariantInterface $productVariant, array $params)
    {
        $product = $productVariant->getProduct();
        $item = $shoppingCart->findItemByProduct($product);
        $quantity = $this->getQuantity($params);
        $quantityToCheck = $this->getQuantityToCheck($product, $quantity, $item);

        $this->checkStock($productVariant, $quantityToCheck);

        if ($item) {
            return $item;
        }

        return $this->itemFactory->make(['quantity' => $quantity, 'variant' => $productVariant]);
    }


    protected function checkStock(Stockable $stockable, $quantity)
    {
        if (! $this->availabilityChecker->isStockSufficient($stockable, $quantity)) {
            throw new InsufficientStockException;
        }
    }

    protected function getQuantity(array $params)
    {
        return array_get($params, 'quantity', 1);
    }

    protected function getQuantityToCheck($product, $quantity, $item = null)
    {
        if ($item && $product->isInClearanceSale()) {
            return $quantity + $item->getQuantity();
        }

        return $quantity;
    }

}