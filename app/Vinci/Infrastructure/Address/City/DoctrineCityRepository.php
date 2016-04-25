<?php

namespace Vinci\Infrastructure\Address\City;

use Vinci\Domain\Address\City\CityRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineCityRepository extends DoctrineBaseRepository implements CityRepository
{

    public function getByState($state)
    {
        $query = $this->_em->createQuery('SELECT c FROM Vinci\Domain\Address\City\City c WHERE c.state = :id');

        $query->setParameter('id', $state);

        return $query->getResult();
    }
}