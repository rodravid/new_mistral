<?php

namespace Vinci\Domain\Customer;

use Closure;
use Doctrine\ORM\EntityManagerInterface;

class CustomerService
{
    private $repository;

    private $entityManager;

    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        CustomerRepository $repository,
        CustomerValidator $validator
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveCustomer($data, function($data) {
            return Customer::make($data);
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveCustomer($data, function($data) use ($id) {

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $customer = $this->repository->find($id);
            $customer->fill($data);

            return $customer;
        });
    }

    protected function saveCustomer($data, Closure $method)
    {
        $customer = $method($data);
        $this->repository->save($customer);
        return $customer;
    }

}