<?php

namespace Vinci\Domain\Inventory;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Inventory\Contracts\Stockable;

class InventoryService
{

    private $entityManager;

    private $stockModifier;

    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        StockModifier $stockModifier,
        Dispatcher $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->stockModifier = $stockModifier;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function reduceStock(Stockable $stockable, $quantity = 1)
    {
        $this->stockModifier->reduceStock($stockable, $quantity);

        $this->persistAndFlushEvents($stockable);
    }

    public function increaseStock(Stockable $stockable, $quantity = 1)
    {
        $this->stockModifier->increaseStock($stockable, $quantity);

        $this->persistAndFlushEvents($stockable);
    }

    public function changeStock(Stockable $stockable, $quantity)
    {
        $this->stockModifier->changeStock($stockable, $quantity);

        $this->persistAndFlushEvents($stockable);
    }

    public function persistAndFlushEvents(Stockable $stockable)
    {
        $this->entityManager->persist($stockable);
        $this->entityManager->flush();

        foreach ($stockable->releaseEvents() as $event) {
            $this->eventDispatcher->fire($event);
        }
    }

}