<?php

namespace Vinci\Domain\Dollar\Providers;

use Vinci\Domain\Dollar\DollarProvider;
use Vinci\Domain\Dollar\DollarRepository;

class DefaultDollarProvider implements DollarProvider
{

    protected $repository;

    protected $dollar;

    public function __construct(DollarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCurrentDollarAmount()
    {
        if ($this->dollar) {
            return $this->dollar;
        }

        return $this->dollar = $this->repository->getLast()->getAmount();
    }
}