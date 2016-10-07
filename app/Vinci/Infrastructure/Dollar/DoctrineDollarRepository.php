<?php

namespace Vinci\Infrastructure\Dollar;

use Carbon\Carbon;
use Vinci\Domain\Dollar\Dollar;
use Vinci\Domain\Dollar\DollarRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineDollarRepository extends DoctrineBaseRepository implements DollarRepository
{

    public function create(array $data)
    {
        $news = Dollar::make($data);
        $this->_em->persist($news);
        $this->_em->flush();
        return $news;
    }

    public function getAll()
    {
        return $this->createQueryBuilder('o')->getQuery()->getResult();
    }

    public function getLast()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getLastValid()
    {
        $qb = $this->createQueryBuilder('o');

        return $qb->where($qb->expr()->lte('o.startsAt', $qb->expr()->literal(Carbon::now())))
            ->orderBy('o.startsAt', 'desc')
            ->orderBy('o.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}