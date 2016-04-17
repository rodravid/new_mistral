<?php

namespace Vinci\Infrastructure\Region;

use Vinci\Domain\Region\Region;
use Vinci\Domain\Region\RegionRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineRegionRepository extends DoctrineSortableRepository implements RegionRepository
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

}