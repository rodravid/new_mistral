<?php

namespace Vinci\Domain\Region;

interface RegionRepository
{

    public function find($id);

    public function create(array $data);

}