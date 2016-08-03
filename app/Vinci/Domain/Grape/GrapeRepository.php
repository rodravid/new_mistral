<?php

namespace Vinci\Domain\Grape;

interface GrapeRepository
{

    public function getAll();

    public function find($id);

    public function getOneBySlug($slug);

    public function create(array $data);

}