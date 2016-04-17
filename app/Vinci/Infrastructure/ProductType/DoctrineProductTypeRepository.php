<?php

namespace Vinci\Infrastructure\ProductType;

use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\ProductType\ProductTypeRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineProductTypeRepository extends DoctrineSortableRepository implements ProductTypeRepository
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
        $country = ProductType::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

}