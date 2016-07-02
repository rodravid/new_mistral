<?php

namespace Vinci\Domain\ERP\Product;

class ProductService
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOneBySKU($sku)
    {
        return $this->repository->getOneBySKU($sku);
    }

    public function getAllProducts()
    {

        return [];


    }

}