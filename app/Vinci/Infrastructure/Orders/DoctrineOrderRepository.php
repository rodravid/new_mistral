<?php

namespace Vinci\Infrastructure\Orders;

use Vinci\Domain\Order\OrderRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineOrderRepository extends DoctrineBaseRepository implements OrderRepository
{

    public function getLastOrders($perPage, $currentPage = 1)
    {
        $query = $this->getBaseQueryBuilder()
                      ->orderBy('o.id', 'desc')
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


    protected function getBaseQueryBuilder()
    {
        return $this->createQueryBuilder('o')
            ->select('o', 'i', 'c')
            ->join('o.items', 'i')
            ->join('o.customer', 'c');
    }

    public function countOrders()
    {
        return (int) $this->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
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

    public function getByPeriod($dateStart, $dateStop)
    {
        $queryBuilder = $this->createQueryBuilder('o');

        $queryBuilder->select('count(o.id) AS orders, DAY(o.createdAt) as day, MONTH(o.createdAt) as month, YEAR(o.createdAt) as year')
                     ->where(
                         $queryBuilder->expr()->between(
                             'o.createdAt',
                             ':dateStart',
                             ':dateStop'
                         )
                     )
                     ->orderBy('year, month, day')
                     ->groupBy('day');

        $queryBuilder->setParameter('dateStart', $dateStart)
                     ->setParameter('dateStop', $dateStop);

        return $queryBuilder->getQuery()->getResult();
    }
}