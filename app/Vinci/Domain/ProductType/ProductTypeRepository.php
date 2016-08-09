<?php

namespace Vinci\Domain\ProductType;

interface ProductTypeRepository
{
    public function getAll();

    public function find($id);

    public function getOneBySlug($slug);

    public function create(array $data);

    public function getAllValidForSelectArray();

}