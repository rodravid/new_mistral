<?php

namespace Vinci\Domain\Dollar;

class DollarService
{
    protected $repository;

    protected $validator;

    public function __construct(DollarRepository $repository, DollarValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $attributes)
    {

    }

}