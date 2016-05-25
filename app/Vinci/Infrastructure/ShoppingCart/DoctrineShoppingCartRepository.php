<?php

namespace Vinci\Infrastructure\ShoppingCart;

use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineShoppingCartRepository extends DoctrineBaseRepository implements ShoppingCartRepository
{

    public function find($id)
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->where($qb->expr()->eq('c.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getLastByCustomer(CustomerInterface $customer)
    {
        $qb = $this->getBaseQueryBuilder();

        $qb
            ->where($qb->expr()->eq('cs.id', $customer->getId()))
            ->orderBy('c.createdAt', 'desc');

        $query = $qb->getQuery();

        $result = $query->getResult();

        return ! empty($result) ? $result[0] : null;
    }

    protected function getBaseQueryBuilder()
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('c', 'cs', 'i', 'p', 'pv', 'pvp')
            ->join('c.customer', 'cs')
            ->join('c.items', 'i')
            ->join('i.product', 'p')
            ->join('i.productVariant', 'pv')
            ->join('pv.prices', 'pvp');

        return $query;
    }

}