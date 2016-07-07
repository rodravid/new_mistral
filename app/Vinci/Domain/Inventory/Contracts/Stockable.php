<?php

namespace Vinci\Domain\Inventory\Contracts;

interface Stockable
{

    public function getStock();

    public function setStock($stock);

    public function changeStock($stock);

    public function increaseStock($quantity = 1);

    public function reduceStock($quantity = 1);

}