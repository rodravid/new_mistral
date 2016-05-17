<?php

namespace Vinci\Domain\Product\Factories;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\ProductType;

class ProductTypeFactory
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(array $data)
    {
        if (isset($data['id'])) {
            return $this->entityManager->getReference(ProductType::class, $data['id']);
        }
        
        $productType = new ProductType();

        $productType->fill($data);

        return $productType;
    }

}