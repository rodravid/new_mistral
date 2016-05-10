<?php

namespace Vinci\Domain\Product\Factories\Contracts;

interface ProductFactory
{

    public function makeFromArray(array $data);

}