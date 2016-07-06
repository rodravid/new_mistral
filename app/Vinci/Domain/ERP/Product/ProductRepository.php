<?php

namespace Vinci\Domain\ERP\Product;

interface ProductRepository
{

    public function getOneBySKU($sku);

    public function getAll();

    public function getNew();

    public function getChanged();

    public function getStock($sku);

}