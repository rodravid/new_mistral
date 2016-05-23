<?php

namespace Vinci\Domain\Product\Repositories;

interface ProductVariantRepository
{
    public function find($id);

    public function getOneValidById($id);
}