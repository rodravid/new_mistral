<?php

namespace Vinci\Domain\Order\Item;

use Doctrine\Common\Collections\Collection;

class ValidItemsFilter
{

    public function filter(Collection $items)
    {
        return $items->filter(function($item) {
            if ($item->getProductVariant()->hasStock()) {
                return $item;
            }
        });
    }

}