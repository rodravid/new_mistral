<?php

namespace Vinci\Infrastructure\DeliveryTrack;

use Vinci\Domain\DeliveryTrack\DeliveryTrack;
use Vinci\Domain\DeliveryTrack\DeliveryTrackRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineDeliveryTrackRepository extends DoctrineBaseRepository implements DeliveryTrackRepository
{

    public function getAll()
    {
        return $this->createQueryBuilder('d')->select('d')->getQuery()->getResult();
    }

    public function find($id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where($qb->expr()->eq('o.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $deliveryTrack = DeliveryTrack::make($data);
        $this->_em->persist($deliveryTrack);
        $this->_em->flush();
        return $deliveryTrack;
    }
}