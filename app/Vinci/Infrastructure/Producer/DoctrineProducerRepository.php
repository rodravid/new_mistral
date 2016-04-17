<?php

namespace Vinci\Infrastructure\Producer;

use Vinci\Domain\Producer\Producer;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineProducerRepository extends DoctrineSortableRepository implements ProducerRepository
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
        $country = Producer::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

}