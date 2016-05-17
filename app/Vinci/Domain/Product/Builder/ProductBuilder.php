<?php

namespace Vinci\Domain\Product\Builder;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\Factories\ProductFactory;
use Vinci\Domain\Product\Factories\ProductTypeFactory;
use Vinci\Domain\Product\ProductInterface;

class ProductBuilder
{

    protected $product;

    protected $entityManager;

    protected $productFactory;

    protected $attributes = [];

    protected $productTypeFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductFactory $productFactory,
        ProductTypeFactory $productTypeFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->productFactory = $productFactory;
        $this->productTypeFactory = $productTypeFactory;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    public function setType($type)
    {
        $type = $this->productTypeFactory->make($type);

        dd($type);

        $this->addAttribute('type', $type);
    }

    public function build()
    {

    }

    protected function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    protected function getAttribute($name)
    {
        if ($this->hasAttribute($name)) {
            return $this->attributes[$name];
        }
    }

    protected function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }

}