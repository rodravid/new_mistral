<?php

namespace Vinci\Infrastructure\Product\Variant;

use Vinci\Domain\Product\Repositories\ProductVariantRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Product\Exceptions\ProductVariantNotFoundException;

class DoctrineProductVariantRepository extends DoctrineBaseRepository implements ProductVariantRepository
{

    public function find($id)
    {
        $qb = $this->createQueryBuilder('v');

        $qb->select('v', 'p')
            ->join('v.product', 'p')
            ->where($qb->expr()->eq('v.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOneValidById($id)
    {
        $variant = $this->find($id);

        if (! $variant) {
            throw new ProductVariantNotFoundException;
        }

        return $variant;
    }
}