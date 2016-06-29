<?php

namespace Vinci\Infrastructure\Payment;


use Carbon\Carbon;
use Vinci\Domain\Payment\Repositories\PaymentInstallmentRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrinePaymentInstallmentRepository extends DoctrineBaseRepository implements PaymentInstallmentRepository
{

    public function getInstallmentQuantityBy($amount, $paymentMethod)
    {
        $currentDate = Carbon::now();

        $queryBuilder = $this->createQueryBuilder('pi');

        $queryBuilder = $queryBuilder
                             ->select('pi')
                             ->where('pi.paymentMethod = :paymentMethod')
                             ->andWhere('pi.startsAt <= :currentDate')
                             ->andWhere($queryBuilder->expr()->orX(
                                 $queryBuilder->expr()->gte('pi.expirationAt', ':currentDate'),
                                 $queryBuilder->expr()->isNull('pi.expirationAt')
                             ))
                             ->andWhere('pi.status = 1')
                             ->andWhere('pi.amount <= :amount')
                             ->orderBy('pi.amount', 'DESC')
                             ->addOrderBy('pi.startsAt', 'DESC');

        $queryBuilder->setParameter('paymentMethod', $paymentMethod);
        $queryBuilder->setParameter('currentDate', $currentDate);
        $queryBuilder->setParameter('amount', $amount);

        $result = $queryBuilder->getQuery()->getResult();

        if (! empty($result)) {
            return $result[0];
        }
    }
}