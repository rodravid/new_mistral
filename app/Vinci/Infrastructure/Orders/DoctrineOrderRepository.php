<?php

namespace Vinci\Infrastructure\Orders;

use Vinci\Domain\Order\OrderRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineOrderRepository extends DoctrineBaseRepository implements OrderRepository
{

    public function getAllCustomerOrders($customerId)
    {
        $query = $this->_em->createQuery("SELECT o, oi, c, p FROM \Vinci\Domain\Order\Order o JOIN o.items oi JOIN oi.product p JOIN o.customer c WHERE c.id = :customer_id");
        $query->setParameter('customer_id', $customerId);
        return $query->getResult();
    }
}