<?php

namespace Vinci\Infrastructure\Graphic\Order;


use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Common\Model\DateRange;
use Vinci\Domain\Graphic\Order\OrderGraphicsRepository;
use Vinci\Domain\Order\OrderStatus;
use Vinci\Domain\Payment\PaymentStatus;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineOrderGraphicsRepository extends DoctrineBaseRepository implements OrderGraphicsRepository
{

    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {

        $this->em = $entityManagerInterface;

    }

    public function countAllByPeriod(DateRange $dateRange)
    {
        $dql = <<<DQL
        
        SELECT o, count(o.id) AS orders, DAY(o.createdAt) as day, MONTH(o.createdAt) as month, YEAR(o.createdAt) as year
        FROM Vinci\Domain\Order\Order o
        WHERE o.createdAt BETWEEN :startAt AND :endAt
        GROUP BY year, month, day
        ORDER BY year, month, day ASC
        
DQL;

        $query = $this->em->createQuery($dql);

        $query->setParameter('startAt', $dateRange->getStart())
              ->setParameter('endAt', $dateRange->getEnd());

        return $query->getResult();
    }

    public function countPaidByPeriod(DateRange $dateRange)
    {
        $dql = <<<DQL
        
        SELECT count(o.id) AS orders, 
            DAY(o.createdAt) as day, 
            MONTH(o.createdAt) as month, 
            YEAR(o.createdAt) as year,
            
            (SELECT count(o2.id)
             FROM Vinci\Domain\Order\Order o2
                  INNER JOIN o2.payments p
             WHERE p.status IN (:statuses)
                 AND DAY(o2.createdAt) = DAY(o.createdAt)
                 AND MONTH(o2.createdAt) = MONTH(o.createdAt)
                 AND YEAR(o2.createdAt) = YEAR(o.createdAt)) AS paidOrders,
                 
            (SELECT count(o3.id)
             FROM Vinci\Domain\Order\Order o3
             WHERE o3.status IN (:completed)
                 AND DAY(o3.createdAt) = DAY(o.createdAt)
                 AND MONTH(o3.createdAt) = MONTH(o.createdAt)
                 AND YEAR(o3.createdAt) = YEAR(o.createdAt)) AS completedOrders
              
        FROM Vinci\Domain\Order\Order o
        WHERE o.createdAt BETWEEN :startAt AND :endAt
        GROUP BY year, month, day
        ORDER BY year, month, day ASC
        
DQL;

        $query = $this->em->createQuery($dql);

        $query->setParameter('startAt', $dateRange->getStart())
              ->setParameter('endAt', $dateRange->getEnd())
              ->setParameter('statuses', [PaymentStatus::STATUS_AUTHORIZED])
              ->setParameter('completed', [OrderStatus::STATUS_COMPLETED]);

        return $query->getResult();
    }
}