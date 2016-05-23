<?php

namespace Vinci\Infrastructure\ShoppingCart;

use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineShoppingCartRepository extends DoctrineBaseRepository implements ShoppingCartRepository
{

    public function find($id)
    {
        $dql = 'SELECT c, i FROM Vinci\Domain\ShoppingCart\ShoppingCart c JOIN c.items i WHERE c.id = :id';
        $query = $this->_em->createQuery($dql);
        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

}