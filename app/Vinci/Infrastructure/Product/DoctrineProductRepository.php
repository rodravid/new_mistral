<?php

namespace Vinci\Infrastructure\Product;

use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineProductRepository extends DoctrineBaseRepository implements ProductRepository
{

    public function find($id)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p', 'v', 'i', 'vp', 'c')
            ->join('p.variants', 'v')
            ->leftJoin('p.channels', 'c')
            ->leftJoin('v.images', 'i')
            ->leftJoin('v.prices', 'vp')
            ->where($qb->expr()->eq('p.id', $id));

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