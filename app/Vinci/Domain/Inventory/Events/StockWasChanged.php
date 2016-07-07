<?php

namespace Vinci\Domain\Inventory\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Inventory\Contracts\Stockable;

class StockWasChanged extends Event
{
    public $stockable;

    public $oldStock;

    public function __construct(Stockable $stockable, $oldStock)
    {
        $this->stockable = $stockable;
        $this->oldStock = $oldStock;
    }
}