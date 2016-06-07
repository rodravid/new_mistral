<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\Domain\Inventory\InventoryService;
use Vinci\Domain\Order\Events\NewOrderWasCreated;

class ReduceStockOfProducts
{

    private $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }
    
    public function handle(NewOrderWasCreated $event)
    {
        $order = $event->order;

        foreach ($order->getItems() as $item) {

            $variant = $item->getProductVariant();
            $quantity = $item->getQuantity();

            $this->inventoryService->reduceStock($variant, $quantity);

        }

    }

}