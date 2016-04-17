<?php

namespace Vinci\Infrastructure\Grape;

use Vinci\Domain\Grape\Grape;
use Vinci\Domain\Grape\GrapeRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineGrapeRepository extends DoctrineSortableRepository implements GrapeRepository
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
        $country = Grape::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

}