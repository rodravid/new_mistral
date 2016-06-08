<?php

namespace Vinci\Domain\Showcase;

interface ShowcaseRepository
{
    public function lists($type);

    public function find($id);

    public function create(array $data);
}