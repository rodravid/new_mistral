<?php

namespace Vinci\Infrastructure\Customer;

use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Infrastructure\Users\DoctrineUserRepository;

class DoctrineCustomerRepository extends DoctrineUserRepository implements CustomerRepository
{

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $query = $this->_em->createQuery('SELECT customer, a, c, s, co FROM Vinci\Domain\Customer\Customer customer
        LEFT JOIN customer.mainAddress a
        LEFT JOIN a.city c
        LEFT JOIN c.state s
        LEFT JOIN s.country co
        WHERE customer.id = :id');

        $query->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $admin = Customer::make($data);
        $this->_em->persist($admin);
        $this->_em->flush();
        return $admin;
    }
}