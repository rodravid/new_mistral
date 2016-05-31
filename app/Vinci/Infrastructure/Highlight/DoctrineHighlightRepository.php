<?php

namespace Vinci\Infrastructure\Highlight;

use Carbon\Carbon;
use Vinci\Domain\Highlight\Highlight;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineHighlightRepository extends DoctrineSortableRepository implements HighlightRepository
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

        $qb->select('o', 'i')
            ->leftJoin('o.images', 'i')
            ->where($qb->expr()->eq('o.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $highlight = Highlight::make($data);
        $this->_em->persist($highlight);
        $this->_em->flush();
        return $highlight;
    }

}