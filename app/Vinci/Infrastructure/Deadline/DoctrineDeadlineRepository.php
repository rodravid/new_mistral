<?php

namespace Vinci\Infrastructure\Deadline;

use Vinci\Domain\Deadline\Deadline;
use Vinci\Domain\Deadline\DeadlineRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineDeadlineRepository extends DoctrineBaseRepository implements DeadlineRepository
{

    public function create(array $data)
    {
        $news = Deadline::make($data);
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
}