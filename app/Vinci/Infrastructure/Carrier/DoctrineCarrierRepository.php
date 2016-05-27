<?php

namespace Vinci\Infrastructure\Carrier;

use Vinci\Domain\Carrier\CarrierInterface;
use Vinci\Domain\Carrier\CarrierRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineCarrierRepository extends DoctrineBaseRepository implements CarrierRepository
{

    public function findByPostalCodeAndWeight($postalCode, $weight)
    {
        $qb = $this->getBaseQueryBuilder();

        $qb
            ->where($qb->expr()->andX(
                $qb->expr()->gte($postalCode, 'm.initialTrack'),
                $qb->expr()->lte($postalCode, 'm.finalTrack')
            ))
            ->andWhere($qb->expr()->andX(
                $qb->expr()->gte($weight, 'm.initialWeight'),
                $qb->expr()->lte($weight, 'm.finalWeight')
            ));

        $qb->join('Vinci\Domain\Carrier\Carrier', 'd', 'with', 'd.code = :code');

        $qb->setParameter('code', CarrierInterface::CARRIER_DEFAULT);

        $query = $qb->getQuery();

        $result = $query->getResult();

        return $result;
    }

    public function getDefaultCarrier()
    {
        $qb = $this->getBaseQueryBuilder();

        return $qb
            ->where($qb->expr()->eq('c.code', $qb->expr()->literal('default')))
            ->getQuery()
            ->getOneOrNullResult();
    }

    protected function getBaseQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'm', 't')
            ->join('c.metrics', 'm')
            ->leftJoin('m.taxes', 't');
    }

}