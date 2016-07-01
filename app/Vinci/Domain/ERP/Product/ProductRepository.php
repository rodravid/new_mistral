<?php

namespace Vinci\Domain\ERP\Product;

interface ProductRepository
{

    public function getOneBySKU($sku);

}