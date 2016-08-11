<?php

namespace Vinci\Domain\Product;

use Vinci\Domain\Common\AggregateRoot;

interface ProductInterface extends AggregateRoot
{

    const TYPE_PRODUCT = 'product';
    const TYPE_WINE = 'wine';
    const TYPE_KIT = 'kit';

    public function canBePromoted();

}