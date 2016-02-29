<?php

namespace Vinci\Domain\User\Admin;

use Illuminate\Database\ConnectionInterface as Database;
use Vinci\Domain\Core\Validation\ValidationTrait;

class AdminService
{
    use ValidationTrait;

    private $repository;

    private $db;

    public function __construct(
        AdminRepository $repository,
        Database $db
    )
    {
        $this->repository = $repository;
        $this->db = $db;
    }

    public function create(array $attributes)
    {
        $this->validate($attributes, $this->getRules(), $this->getMessages());

        return $this->db->transaction(function() use ($attributes) {

            $admin = $this->createUserIfNotExists($attributes);

            $this->repository->createProfile($attributes, $admin->id);

            return $admin;
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
            'email' => 'required|unique_user:admin',
            'password' => 'required'
        ];

        if (! empty($ignoreId)) {
            $rules['email'] .= ",{$ignoreId}";
        }

        return $rules;
    }

}