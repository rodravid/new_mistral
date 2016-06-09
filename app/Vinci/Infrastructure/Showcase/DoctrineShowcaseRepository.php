<?php

namespace Vinci\Infrastructure\Showcase;

use Carbon\Carbon;
use Vinci\Domain\Showcase\Showcase;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineShowcaseRepository extends DoctrineSortableRepository implements ShowcaseRepository
{
    public function lists($type, $max = 4)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->select('o', 'i', 't', 'p', 'v')
            ->join('o.items', 'i')
            ->join('o.template', 't')
            ->join('i.product', 'p')
            ->join('p.variants', 'v')
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

    public function getItems($showcaseId)
    {

    }

    public function getItemsQueryBuilder($alias)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select($alias)
            ->from('Vinci\Domain\Showcase\ShowcaseItem', $alias);

        return $qb;
    }

    public function getOneById($id)
    {
        $showcase = $this->find($id);

        if (! $showcase) {
            throw new EntityNotFoundException;
        }

        return $showcase;
    }
}