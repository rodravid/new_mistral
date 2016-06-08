<?php

namespace Vinci\Infrastructure\Showcase;

use Carbon\Carbon;
use Vinci\Domain\Showcase\Showcase;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineShowcaseRepository extends DoctrineSortableRepository implements ShowcaseRepository
{
    public function lists($type)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->select('o', 'i')
            ->leftJoin('o.images', 'i')
            ->where($qb->expr()->lte('o.startsAt', $qb->expr()->literal(Carbon::now())))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->gte('o.expirationAt', $qb->expr()->literal(Carbon::now())),
                $qb->expr()->isNull('o.expirationAt')
            ))
            ->andWhere($qb->expr()->eq('o.status', 1))
            ->andWhere($qb->expr()->eq('o.type',  $qb->expr()->literal($type)));

        return $qb->getQuery()->getResult();
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
        $showcase = Showcase::make($data);
        $this->_em->persist($showcase);
        $this->_em->flush();
        return $showcase;
    }

}