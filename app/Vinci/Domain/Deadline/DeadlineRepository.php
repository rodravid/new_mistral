<?php

namespace Vinci\Domain\Deadline;

interface DeadlineRepository
{

    public function getAll();

    public function create(array $attributes);

    public function getLast();

}