<?php

namespace Vinci\Domain\Product\Repositories;

interface ProductRepository
{
    public function find($id);

    public function findOneByIdAndChannel($id, $channel);

    public function getProductsById(array $productsIds);

}