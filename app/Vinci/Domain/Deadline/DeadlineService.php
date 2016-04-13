<?php

namespace Vinci\Domain\Deadline;

use Closure;

class DeadlineService
{
    protected $repository;

    protected $validator;

    public function __construct(DeadlineRepository $repository, DeadlineValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $attributes)
    {
        $this->validator->with($attributes)->passesOrFail();

        return $this->saveDeadline($attributes, function($data) {
            return Deadline::make($data);
        });
    }

    protected function saveDeadline($data, Closure $method)
    {
        $dollar = $method($data);

        $this->repository->save($dollar);

        return $dollar;
    }

}