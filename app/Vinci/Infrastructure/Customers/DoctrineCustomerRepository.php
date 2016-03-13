<?php

namespace Vinci\Infrastructure\Customers;

use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineCustomerRepository extends DoctrineBaseRepository implements CustomerRepository
{

    public function createProfile(array $attributes, $customerId)
    {
        // TODO: Implement createProfile() method.
    }

    public function updateProfile(array $attributes, $customerId)
    {
        // TODO: Implement updateProfile() method.
    }

    public function findByEmail($email)
    {
        // TODO: Implement findByEmail() method.
    }
}