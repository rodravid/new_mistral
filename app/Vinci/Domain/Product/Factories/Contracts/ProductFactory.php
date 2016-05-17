<?php

namespace Vinci\Domain\Product\Factories\Contracts;

use Vinci\Domain\Product\Product;

interface ProductFactory
{

    public function make(array $data);

    public function override(Product $product, array $data);

    public function getInstanceFromType($type);

}