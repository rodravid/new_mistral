<?php

namespace Vinci\Domain\Dollar;

use Closure;

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
        $this->validator->with($attributes)->passesOrFail();

        return $this->saveDollar($attributes, function($data) {

            $dollar = Dollar::make();

            $dollar->setStartsAtFromFormat($data['startsAt']);

            unset($data['startsAt']);

            $dollar->fill($data);

            return $dollar;
        });
    }

    protected function saveDollar($data, Closure $method)
    {
        $dollar = $method($data);

        $this->repository->save($dollar);

        return $dollar;
    }

}