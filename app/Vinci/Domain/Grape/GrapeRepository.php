<?php

namespace Vinci\Domain\Grape;

interface GrapeRepository
{

    public function find($id);

    public function create(array $data);

}