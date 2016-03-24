<?php

namespace Vinci\Domain\Customer;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Core\Validation\ValidationTrait;

class CustomerService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    public function __construct(
        CustomerRepository $repository,
        EntityManagerInterface $entityManager
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function create(array $attributes)
    {
        $this->validate($attributes, $this->getRules());

        $customer = Customer::make($attributes);

        $customer->setPassword(bcrypt($attributes['password']));
        $customer->setCreatedAt(Carbon::now());

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function update(array $attributes, $customerId)
    {
        $this->validate($attributes, $this->getRules($customerId));

        $this->db->transaction(function() use ($attributes, $customerId) {

            $this->repository->update($attributes, $customerId);
            $this->repository->updateProfile($attributes, $customerId);

        });

    }

    protected function createUserIfNotExists(array $attributes)
    {
        $customer = $this->repository
            ->skipCriteria()
            ->findByEmail($attributes['email']);

        if (empty($customer)) {
            $customer = $this->repository->create($attributes);
        }

        return $customer;
    }

    protected function getRules($ignoreId = null)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:Vinci\Domain\Customer\Customer,email',
            'cpf' => 'required|unique:Vinci\Domain\Customer\Customer,cpf',
            'password' => 'required'
        ];

        if (! empty($ignoreId)) {
            $rules['email'] .= ",{$ignoreId}";
        }

        return $rules;
    }

}