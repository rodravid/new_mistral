<?php

namespace Vinci\Domain\Inventory\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Inventory\Contracts\Stockable;

class StockWasIncreased extends Event
{

    public $stockable;

    public $newStock;

    public function __construct(Stockable $stockable, $newStock)
    {
        $this->stockable = $stockable;
        $this->newStock = $newStock;
    }

}