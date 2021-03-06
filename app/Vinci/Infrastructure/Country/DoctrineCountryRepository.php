<?php

namespace Vinci\Infrastructure\Country;

use Vinci\Domain\Country\Country;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

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
        $this->_em->getFilters()->enable('toggleable');

        $query = $this->_em
            ->createQueryBuilder()
            ->select('country')
            ->from('Vinci\Domain\Country\Country', 'country')
            ->getQuery();

        $result = $query->getResult();

        $this->_em->getFilters()->disable('toggleable');

        return $result;
    }

    public function getOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.slug = :slug');

        $qb->setParameter('slug', $slug);

        $result = $qb->getQuery()->getOneOrNullResult();

        if (! $result) {
            throw new EntityNotFoundException;
        }

        return $result;
    }

    public function getAllValidForSelectArray()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.id', 'c.name');

        $result = $qb->getQuery()->getArrayResult();

        $countries = [];

        foreach ($result as $c) {
            $countries[$c['id']] = $c['name'];
        }

        return $countries;
    }
}