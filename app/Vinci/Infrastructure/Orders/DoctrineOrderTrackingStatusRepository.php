<?php

namespace Vinci\Infrastructure\Orders;

use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatusRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineOrderTrackingStatusRepository extends DoctrineBaseRepository implements OrderTrackingStatusRepository
{

    public function getAll()
    {
        return $this->createQueryBuilder('o')->select('o')->getQuery()->getResult();
    }

    public function getOneById($id)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->where('o.id = :id');

        $qb->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOneByCode($code)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->where('o.code = :code');

        $qb->setParameter('code', $code);

        $result = $qb->getQuery()->getOneOrNullResult();

        if (! $result) {
            throw new EntityNotFoundException('Order tracking status not found.');
        }

        return $result;
    }
}