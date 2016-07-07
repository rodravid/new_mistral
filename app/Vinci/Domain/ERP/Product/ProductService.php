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
        return collect($this->repository->getAll());
    }

    public function getNewProducts()
    {
        return collect($this->repository->getNew());
    }

    public function getChangedProducts()
    {
        return collect($this->repository->getChanged());
    }

    public function getStock($sku)
    {
        return $this->repository->getStock($sku);
    }

}