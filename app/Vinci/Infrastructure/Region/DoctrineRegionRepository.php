<?php

namespace Vinci\Infrastructure\Region;

use Vinci\Domain\Region\Region;
use Vinci\Domain\Region\RegionRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineRegionRepository extends DoctrineBaseRepository implements RegionRepository
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
        $country = Region::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

    public function getAll()
    {
        $this->_em->getFilters()->enable('toggleable');

        $query = $this->_em
            ->createQueryBuilder()
            ->select('region')
            ->from('Vinci\Domain\Region\Region', 'region')
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
        $qb = $this->createQueryBuilder('o')
            ->select('o.id', 'o.name');

        $result = $qb->getQuery()->getArrayResult();

        $countries = [];

        foreach ($result as $o) {
            $countries[$o['id']] = $o['name'];
        }

        return $countries;
    }
}