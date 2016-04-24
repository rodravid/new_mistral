<?php

namespace Vinci\Infrastructure\Address\State;

use Vinci\Domain\Address\State\StateRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineStateRepository extends DoctrineBaseRepository implements StateRepository
{

    public function getByCountry($country)
    {
        $query = $this->_em->createQuery('SELECT s FROM Vinci\Domain\Address\State\State s WHERE s.country = :id');

        $query->setParameter('id', $country);

        return $query->getResult();
    }
}