<?php

namespace Vinci\Domain\Dollar;

interface DollarRepository
{

    public function getAll();

    public function create(array $attributes);

    public function getLastValue();

}