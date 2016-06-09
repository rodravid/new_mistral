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
        $qb = $this->getBySortableGroupsQueryBuilder();

        $qb->select('n', 'i', 't', 'p', 'v')
            ->join('n.items', 'i')
            ->join('n.template', 't')
            ->join('i.product', 'p')
            ->join('p.variants', 'v')
            ->where($qb->expr()->lte('n.startsAt', $qb->expr()->literal(Carbon::now())))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->gte('n.expirationAt', $qb->expr()->literal(Carbon::now())),
                $qb->expr()->isNull('n.expirationAt')
            ))
            ->andWhere($qb->expr()->eq('n.status', 1))
            ->andWhere($qb->expr()->eq('n.type',  $qb->expr()->literal($type)));

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