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
        LEFT JOIN customer.addresses a
        LEFT JOIN a.city c
        LEFT JOIN c.state s
        LEFT JOIN s.country co
        WHERE customer.id = :id');

        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $customer = Customer::make($data);
        $this->_em->persist($customer);
        $this->_em->flush();
        return $customer;
    }

    public function countCustomers()
    {
        return (int) $this->createQueryBuilder('c')->select('count(c.id)')->getQuery()->getSingleScalarResult();
    }

    public function findByDocument($document)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->where('o.cpf = :cpf');

        $qb->setParameter('cpf', $document);

        return $qb->getQuery()->getOneOrNullResult();
    }
}