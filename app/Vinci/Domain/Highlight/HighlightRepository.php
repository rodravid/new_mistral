<?php

namespace Vinci\Domain\Highlight;

interface HighlightRepository
{
    public function lists();
    public function find($id);
    public function create(array $data);
}