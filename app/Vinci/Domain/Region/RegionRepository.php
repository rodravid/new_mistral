<?php

namespace Vinci\Domain\Region;

interface RegionRepository
{

    public function find($id);

    public function getOneBySlug($slug);

    public function getAll();

    public function getAllValidForSelectArray();

    public function create(array $data);

}