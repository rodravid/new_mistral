<?php

namespace Vinci\Infrastructure\Orders;

use Vinci\Domain\Order\OrderRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineOrderRepository extends DoctrineBaseRepository implements OrderRepository
{

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

    public function getByCustomer($customerId, $perPage = 10, $pageName = 'page')
    {
        $query = $this->_em->createQuery("SELECT o, oi, c, p FROM \Vinci\Domain\Order\Order o JOIN o.items oi JOIN oi.product p JOIN o.customer c WHERE c.id = :customer_id");
        $query->setParameter('customer_id', $customerId);

        return $this->paginate($query, $perPage, $pageName);
    }


    protected function getBaseQueryBuilder()
    {

    }
}