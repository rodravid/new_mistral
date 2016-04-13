<?php

namespace Vinci\Infrastructure\Dollar;

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

    public function getLastValue()
    {
        // TODO: Implement getLastValue() method.
    }
}