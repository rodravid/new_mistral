<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Vinci\Domain\Product\ProductInterface;

class DiscountPromotionService
{

    public function findValidPromotionFor(ProductInterface $product)
    {
        if ($product->canBePromoted()) {

            //@TODO Procurar uma promocao de desconto válida para o produto.

        }
    }

}