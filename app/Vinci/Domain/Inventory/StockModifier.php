<?php

namespace Vinci\Domain\Inventory;

use Vinci\Domain\Inventory\Contracts\Stockable;

class StockModifier
{

    public function reduceStock(Stockable $stockable, $quantity = 1)
    {
        $quantity = $stockable->getStock() - intval($quantity);
        $stockable->setStock($quantity);
    }

    public function increaseStock(Stockable $stockable, $quantity = 1)
    {
        $quantity = $stockable->getStock() + intval($quantity);
        $stockable->setStock($quantity);
    }

    public function changeStock(Stockable $stockable, $quantity)
    {
        $stockable->changeStock(intval($quantity));
    }

}