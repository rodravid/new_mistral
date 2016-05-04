<?php

namespace Vinci\Infrastructure\Product;

use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineProductRepository extends DoctrineBaseRepository implements ProductRepository
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
        $highlight = Product::make($data);
        $this->_em->persist($highlight);
        $this->_em->flush();
        return $highlight;
    }

}