<?php

namespace Vinci\Domain\Product\Factories\Contracts;

interface ProductFactory
{

    public function make(array $data);

    public function getInstanceFromType($type);

}