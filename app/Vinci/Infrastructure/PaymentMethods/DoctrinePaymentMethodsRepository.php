<?php

namespace Vinci\Infrastructure\PaymentMethods;


use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrinePaymentMethodsRepository extends DoctrineBaseRepository implements PaymentMethodsRepository
{
    public function getAll()
    {
        $query = $this->createQueryBuilder('pm')
                      ->select('pm')
                      ->where('pm.status = 1')
                      ->orderBy('pm.id');

        $paymentMethods = $query->getQuery()->getResult();

        return $paymentMethods;
    }
}