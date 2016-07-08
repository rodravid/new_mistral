<?php

namespace Vinci\Infrastructure\Graphic\Order;


use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Graphic\Order\OrderGraphicsRepository;
use Vinci\Domain\Payment\PaymentStatus;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineOrderGraphicsRepository extends DoctrineBaseRepository implements OrderGraphicsRepository
{

    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {

        $this->em = $entityManagerInterface;

    }

    public function countAllByPeriod($startAt, $endAt)
    {
        $dql = <<<DQL
        
        SELECT o, count(o.id) AS orders, DAY(o.createdAt) as day, MONTH(o.createdAt) as month, YEAR(o.createdAt) as year
        FROM Vinci\Domain\Order\Order o
        WHERE o.createdAt BETWEEN :startAt AND :endAt
        GROUP BY year, month, day
        ORDER BY year, month, day ASC
        
DQL;

        $query = $this->em->createQuery($dql);

        $query->setParameter('startAt', $startAt)
              ->setParameter('endAt', $endAt);

        return $query->getResult();
    }

    public function countPaidByPeriod($startAt, $endAt)
    {
        $dql = <<<DQL
        
        SELECT count(o.id) AS orders, DAY(o.createdAt) as day, MONTH(o.createdAt) as month, YEAR(o.createdAt) as year,
            (SELECT count(o2.id)
             FROM Vinci\Domain\Order\Order o2
                  INNER JOIN o2.payments p
             WHERE p.status IN (:statuses)
              AND DAY(o2.createdAt) = DAY(o.createdAt)
              AND MONTH(o2.createdAt) = MONTH(o.createdAt)
              AND YEAR(o2.createdAt) = YEAR(o.createdAt)) AS paidOrders
              
        FROM Vinci\Domain\Order\Order o
        WHERE o.createdAt BETWEEN :startAt AND :endAt
        GROUP BY year, month, day
        ORDER BY year, month, day ASC
DQL;

        $query = $this->em->createQuery($dql);

        $query->setParameter('startAt', $startAt)
              ->setParameter('endAt', $endAt)
              ->setParameter('statuses', [PaymentStatus::STATUS_AUTHORIZED, PaymentStatus::STATUS_COMPLETED]);

        return $query->getResult();
    }
}