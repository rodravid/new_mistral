<?php

namespace Vinci\Infrastructure\Customers;

use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Users\DoctrineUserRepository;

class DoctrineCustomerRepository extends DoctrineUserRepository implements CustomerRepository
{

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }
}