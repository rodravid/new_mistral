<?php

namespace Vinci\Domain\Highlight;

interface HighlightRepository
{
    public function lists($type);
    public function find($id);
    public function create(array $data);
}