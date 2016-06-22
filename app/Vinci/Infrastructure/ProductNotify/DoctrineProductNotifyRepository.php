<?php

namespace Vinci\Infrastructure\ProductNotify;

use Vinci\Domain\Product\Notify\Repositories\ProductNotifyRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineProductNotifyRepository extends DoctrineBaseRepository implements ProductNotifyRepository
{
    public function registerNotify($data)
    {
        $data['product'] = $this->find($data['product']);

        $productNotify = ProductNotify::make($data);

        $this->_em->persist($productNotify);
        $this->_em->flush();
    }

    public function hasntRegisteredYet($data)
    {
        $query = $this->createQueryBuilder('pn');

        $query = $query->where('product_id', '=', $data['product'])
                       ->where('customer_email', '=', $data['customer_email']);

        $productNotify = $query->getQuery();

        dd($productNotify);
    }
}