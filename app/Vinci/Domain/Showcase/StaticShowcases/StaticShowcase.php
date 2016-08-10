<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\Showcase;

abstract class StaticShowcase extends Showcase
{

    public abstract function isSatisfiedBy(ProductInterface $product);

}