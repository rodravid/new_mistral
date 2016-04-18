<?php

namespace Vinci\Infrastructure\Country;

use Vinci\Domain\Country\Country;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineCountryRepository extends DoctrineBaseRepository implements CountryRepository
{

    public function find($id)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->select('o', 'i')
            ->leftJoin('o.images', 'i')
            ->where($qb->expr()->eq('o.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $country = Country::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

    public function getAll()
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('country')
            ->from('Vinci\Domain\Country\Country', 'country')
            ->getQuery();

        return $query->getResult();
    }

}