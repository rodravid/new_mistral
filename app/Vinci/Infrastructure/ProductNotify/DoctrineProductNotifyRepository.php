<?php

namespace Vinci\Infrastructure\ProductNotify;

use Vinci\Domain\Product\Notify\Repositories\ProductNotifyRepository;
use Vinci\Domain\ProductNotify\ProductNotify;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineProductNotifyRepository extends DoctrineBaseRepository implements ProductNotifyRepository
{
    public function registerNotify($data)
    {
        $productNotify = ProductNotify::make($data);

        $this->persistAndFlush($productNotify);
    }

    public function hasntRegisteredYet($data)
    {
        $query = $this->createQueryBuilder('pn')
                      ->select('pn')
                      ->where('pn.product = ' . $data['product'])
                      ->andWhere('pn.customer_email = \'' . (string) $data['customer_email'] . '\'');

        return $productNotify = $query->getQuery()->getOneOrNullResult();
    }

    public function persistAndFlush($productNotify)
    {

        $this->_em->persist($productNotify);
        $this->_em->flush();

    }
}