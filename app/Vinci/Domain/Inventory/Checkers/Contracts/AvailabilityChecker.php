<?php

namespace Vinci\Domain\Inventory\Checkers\Contracts;

use Vinci\Domain\Inventory\Contracts\Stockable;

interface AvailabilityChecker
{

    public function isStockSufficient(Stockable $stockable, $quantity);

}