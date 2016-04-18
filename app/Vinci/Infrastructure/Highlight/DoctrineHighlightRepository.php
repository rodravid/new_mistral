<?php

namespace Vinci\Infrastructure\Highlight;

use Vinci\Domain\Highlight\Highlight;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Infrastructure\Common\DoctrineSortableRepository;

class DoctrineHighlightRepository extends DoctrineSortableRepository implements HighlightRepository
{

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