<?php

namespace Vinci\Infrastructure\Customer\Address;

use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineAddressRepository extends DoctrineBaseRepository implements AddressRepository
{

    public function getOneById($id)
    {
        $address = $this->find($id);

        if (! $address) {
            throw new EntityNotFoundException;
        }

        return $address;
    }

    public function getAllByCustomer($customer)
    {
        $dql = 'SELECT a FROM Vinci\Domain\Customer\Address\Address a JOIN a.customer c WHERE c.id = :customer';
        $query = $this->_em->createQuery($dql);

        $query->setParameter('customer', $customer);

        return $query->getResult();
    }

}