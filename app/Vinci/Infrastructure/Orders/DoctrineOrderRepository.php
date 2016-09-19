<?php

namespace Vinci\Infrastructure\Orders;

use Vinci\Domain\Common\Model\DateRange;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\Order\OrderStatus;
use Vinci\Domain\Payment\PaymentStatus;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineOrderRepository extends DoctrineBaseRepository implements OrderRepository
{
    public function getAll($perPage, $currentPage = 1)
    {
        $query = $this->getBaseQueryBuilder()
                             ->orderBy('o.createdAt', 'desc')
                             ->getQuery();

        return $this->paginateRaw($query, $perPage, $currentPage);
    }

    public function getAllFilteredBy(array $filters)
    {
        $queryBuilder = $this->getBaseQueryBuilder()
            ->where('o.id = :id OR o.number = :keyword OR c.name LIKE :keyword');

        $queryBuilder->setParameter('id', $filters['keyword']);
        $queryBuilder->setParameter('keyword', '%' . $filters['keyword'] . '%');

        if ($this->shouldFilterByOrderTrackingStatus($filters)) {
            $queryBuilder = $this->applyAndSetOrderTrackingStatus($queryBuilder, $filters['orderTrackingStatus']);
        }

        if ($this->shouldFilterByStartDate($filters)) {
            $queryBuilder = $this->applyAndSetStartDateOfPeriod($queryBuilder, $filters['startDate']);
        }

        if ($this->shouldFilterByEndDate($filters)) {
            $queryBuilder = $this->applyAndSetEndDateOfPeriod($queryBuilder, $filters['endAt']);
        }

        $queryBuilder->orderBy('o.createdAt', 'desc');

        if ($this->shouldPaginate($filters['itemsPerPage'])) {
            return $this->paginate($queryBuilder->getQuery(), $filters['itemsPerPage']);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function shouldFilterByOrderTrackingStatus($filters)
    {
        return !! $filters['orderTrackingStatus'];
    }

    private function applyAndSetOrderTrackingStatus($queryBuilder, $orderTrackingStatus)
    {
        $queryBuilder->andWhere('o.trackingStatus = :trackingStatus');
        $queryBuilder->setParameter('trackingStatus', $orderTrackingStatus);

        return $queryBuilder;
    }

    private function shouldFilterByStartDate($filters)
    {
        return ! empty($filters['startDate']);
    }

    private function applyAndSetStartDateOfPeriod($queryBuilder, $startDate)
    {
        $queryBuilder->andWhere('o.createdAt >= :startDate');
        $queryBuilder->setParameter('startDate', $startDate);

        return $queryBuilder;
    }

    private function shouldFilterByEndDate($filters)
    {
        return ! empty($filters['endAt']);
    }

    private function applyAndSetEndDateOfPeriod($queryBuilder, $endAt)
    {
        $queryBuilder->andWhere('o.createdAt <= :endAt');
        $queryBuilder->setParameter('endAt', $endAt);

        return $queryBuilder;
    }

    public function getLastOrders($perPage, $currentPage = 1)
    {
        $query = $this->getBaseQueryBuilder()
                      ->orderBy('o.createdAt', 'desc')
                      ->getQuery();

        return $this->paginateRaw($query, $perPage, $currentPage);
    }

    public function find($id)
    {
        $dql = <<<DQL
        SELECT o, c, i, sa, ba FROM Vinci\Domain\Order\Order o
        LEFT JOIN o.customer c
        LEFT JOIN o.items i
        LEFT JOIN o.shippingAddress sa
        LEFT JOIN o.billingAddress ba
        WHERE o.id = :id
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    public function getOneById($id)
    {
        $order = $this->find($id);

        if (! $order) {
            throw new EntityNotFoundException;
        }

        return $order;
    }

    public function getByCustomer($customerId, $perPage = 5, $pageName = 'page')
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->where($qb->expr()->eq('c.id', $customerId))
            ->orderBy('o.createdAt', 'desc');

        return $this->paginate($qb->getQuery(), $perPage, $pageName);
    }

    public function getItemById($id)
    {
        $dql = <<<DQL
        SELECT i, o FROM Vinci\Domain\Order\Item\OrderItem i
        JOIN i.order o
        WHERE i.id = :id
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    protected function getBaseQueryBuilder()
    {
        return $this->createQueryBuilder('o')
            ->select('o', 'i', 'c', 'p', 's')
            ->join('o.items', 'i')
            ->join('o.customer', 'c')
            ->join('o.payments', 'p')
            ->join('o.shipment', 's');
    }

    public function countOrders()
    {
        return (int) $this->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
    }

    public function countOrdersByPeriod(DateRange $dateRange)
    {

        $dql = <<<DQL
        SELECT count(o.id)
        FROM Vinci\Domain\Order\Order o
        WHERE o.createdAt BETWEEN :startAt AND :endAt
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('startAt', $dateRange->getStart())
              ->setParameter('endAt', $dateRange->getEnd());

        return (int) $query->getSingleScalarResult();
    }

    public function countPaidOrdersByPeriod(DateRange $dateRange)
    {
        $dql = <<<DQL
        SELECT count(o.id)
        FROM Vinci\Domain\Order\Order o
        INNER JOIN o.payments p
        WHERE o.createdAt BETWEEN :startAt AND :endAt
            AND p.status IN (:statuses)
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('startAt', $dateRange->getStart())
              ->setParameter('endAt', $dateRange->getEnd())
              ->setParameter('statuses', [PaymentStatus::STATUS_AUTHORIZED, PaymentStatus::STATUS_COMPLETED]);

        return (int) $query->getSingleScalarResult();
    }

    public function countWaitingPaymentOrdersByPeriod(DateRange $dateRange)
    {
        $dql = <<<DQL
        SELECT count(o.id)
        FROM Vinci\Domain\Order\Order o
        INNER JOIN o.payments p
        WHERE o.createdAt BETWEEN :startAt AND :endAt
            AND p.status IN (:statuses)
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('startAt', $dateRange->getStart())
            ->setParameter('endAt', $dateRange->getEnd())
            ->setParameter('statuses', [PaymentStatus::STATUS_PROCESSING, PaymentStatus::STATUS_PENDING, PaymentStatus::STATUS_NEW]);

        return (int) $query->getSingleScalarResult();
    }

    public function countCompletedOrdersByPeriod(DateRange $dateRange)
    {
        $dql = <<<DQL
        SELECT count(o.id)
        FROM Vinci\Domain\Order\Order o
        INNER JOIN o.payments p
        WHERE o.createdAt BETWEEN :startAt AND :endAt
            AND o.status IN (:statuses)
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('startAt', $dateRange->getStart())
              ->setParameter('endAt', $dateRange->getEnd())
              ->setParameter('statuses', [OrderStatus::STATUS_COMPLETED]);

        return (int) $query->getSingleScalarResult();
    }

    public function getOneByNumber($number)
    {
        $dql = <<<DQL
        SELECT o, c, i, sa, ba FROM Vinci\Domain\Order\Order o
        LEFT JOIN o.customer c
        LEFT JOIN o.items i
        LEFT JOIN o.shippingAddress sa
        LEFT JOIN o.billingAddress ba
        WHERE o.number = :number
DQL;

        $query = $this->_em->createQuery($dql);

        $query->setParameter('number', $number);

        $order = $query->getOneOrNullResult();

        if (! $order) {
            throw new EntityNotFoundException;
        }

        return $order;
    }

    public function getItemsQuery($alias)
    {
        $qb = $this->_em->createQueryBuilder();

        return $qb->select($alias)
            ->from(OrderItem::class, $alias);
    }

    private function shouldPaginate($itemsPerPage)
    {
        return !! $itemsPerPage;
    }
}