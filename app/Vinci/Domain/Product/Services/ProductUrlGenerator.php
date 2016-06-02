<?php

namespace Vinci\Domain\Product\Services;

use Vinci\Domain\Product\ProductInterface;

class ProductUrlGenerator
{

    public function generate(ProductInterface $product)
    {
        switch($product->getType()) {

            case $product::TYPE_WINE:
                return sprintf('/p/vinho/%s', $product->getSlug());
                break;
        }

    }

}