<?php

namespace Vinci\Infrastructure\Customer;

use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Infrastructure\Users\DoctrineUserRepository;

class DoctrineCustomerRepository extends DoctrineUserRepository implements CustomerRepository
{

    public function create(array $data)
    {
        $admin = Customer::make($data);
        $this->_em->persist($admin);
        $this->_em->flush();
        return $admin;
    }
}