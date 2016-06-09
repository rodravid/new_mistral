<?php

namespace Vinci\Domain\Showcase;

interface ShowcaseRepository
{
    public function lists($type, $max = 4);

    public function find($id);

    public function getOneById($id);

    public function create(array $data);

    public function getItems($showcaseId);
    
}