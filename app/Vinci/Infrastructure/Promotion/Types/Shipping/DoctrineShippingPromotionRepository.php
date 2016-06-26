<?php

namespace Vinci\Infrastructure\Promotion\Types\Shipping;

use Carbon\Carbon;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Promotion\Types\Shipping\ShippingPromotionRepository;
use Vinci\Domain\Showcase\Showcase;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineShippingPromotionRepository extends DoctrineBaseRepository implements ShippingPromotionRepository
{

    public function find($id)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->select('o')
            ->where($qb->expr()->eq('o.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $showcase = Showcase::make($data);
        $this->_em->persist($showcase);
        $this->_em->flush();
        return $showcase;
    }

    public function getOneById($id)
    {
        $showcase = $this->find($id);

        if (! $showcase) {
            throw new EntityNotFoundException;
        }

        return $showcase;
    }

    public function findOneByPostalCodeAndAmount(PostalCode $postalCode, $amount)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->join('p.deliveryTracks', 'd')
            ->join('d.lines', 'l')
            ->where($qb->expr()->lte('p.startsAt', $qb->expr()->literal(Carbon::now())))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->gte('p.expirationAt', $qb->expr()->literal(Carbon::now())),
                $qb->expr()->isNull('p.expirationAt')
            ))
            ->andWhere($qb->expr()->andX(
                $qb->expr()->gte($postalCode->getCode(), 'l.initialTrack'),
                $qb->expr()->lte($postalCode->getCode(), 'l.finalTrack')
            ))
            ->andWhere($qb->expr()->lte('p.initialAmount', $amount))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->gte('p.finalAmount', $amount),
                $qb->expr()->isNull('p.finalAmount')
            ))
            ->andWhere($qb->expr()->eq('p.status', Status::ACTIVE))
            ->orderBy('p.startsAt', 'asc');

        $result = $qb->getQuery()->getResult();

        if (! empty($result)) {
            return $result[0];
        }
    }
}