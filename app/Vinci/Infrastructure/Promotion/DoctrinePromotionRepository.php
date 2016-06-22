<?php

namespace Vinci\Infrastructure\Promotion;

use Vinci\Domain\Promotion\PromotionRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrinePromotionRepository extends DoctrineBaseRepository implements PromotionRepository
{

    public function getOneById($id)
    {
        $showcase = $this->find($id);

        if (! $showcase) {
            throw new EntityNotFoundException;
        }

        return $showcase;
    }

    public function getItemsQueryBuilder($alias)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select($alias)
            ->from('Vinci\Domain\Promotion\PromotionItem', $alias);

        return $qb;
    }
}