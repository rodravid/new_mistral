<?php

namespace Vinci\Domain\ProductType;

interface ProductTypeRepository
{

    public function find($id);

    public function create(array $data);

}