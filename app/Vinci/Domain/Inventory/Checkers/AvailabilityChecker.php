<?php

namespace Vinci\Domain\Inventory\Checkers;

use Vinci\Domain\Inventory\Checkers\Contracts\AvailabilityChecker as AvailabilityCheckerInterface;
use Vinci\Domain\Inventory\Contracts\Stockable;

class AvailabilityChecker implements AvailabilityCheckerInterface
{

    public function isStockSufficient(Stockable $stockable, $quantity)
    {
        return $quantity <= $stockable->getStock();
    }
}