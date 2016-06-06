<?php

namespace Vinci\Domain\Inventory;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Inventory\Contracts\Stockable;

class InventoryService
{

    private $entityManager;

    private $stockModifier;

    public function __construct(
        EntityManagerInterface $entityManager,
        StockModifier $stockModifier
    ) {
        $this->entityManager = $entityManager;
        $this->stockModifier = $stockModifier;
    }

    public function reduceStock(Stockable $stockable, $quantity = 1)
    {
        $this->stockModifier->reduceStock($stockable, $quantity);

        $this->entityManager->persist($stockable);
        $this->entityManager->flush();
    }

    public function increaseStock(Stockable $stockable, $quantity = 1)
    {
        $this->stockModifier->increaseStock($stockable, $quantity);

        $this->entityManager->persist($stockable);
        $this->entityManager->flush();
    }

}