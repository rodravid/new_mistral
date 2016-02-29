<?php

namespace Vinci\Domain\User\Customer;

use Illuminate\Database\ConnectionInterface as Database;
use Vinci\Domain\Core\Validation\ValidationTrait;

class CustomerService
{
    use ValidationTrait;

    private $repository;

    private $db;

    public function __construct(
        CustomerRepository $repository,
        Database $db
    )
    {
        $this->repository = $repository;
        $this->db = $db;
    }

    public function create(array $attributes)
    {
        $this->validate($attributes, $this->getRules());

        return $this->db->transaction(function() use ($attributes) {

            $customer = $this->createUserIfNotExists($attributes);

            $this->repository->createProfile($attributes, $customer->id);

            return $customer;
        });
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
            'email' => 'required|unique_user:customer',
            'password' => 'required'
        ];

        if (! empty($ignoreId)) {
            $rules['email'] .= ",{$ignoreId}";
        }

        return $rules;
    }

}