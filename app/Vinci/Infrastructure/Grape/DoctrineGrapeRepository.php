<?php

namespace Vinci\Infrastructure\Grape;

use Vinci\Domain\Grape\Grape;
use Vinci\Domain\Grape\GrapeRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineGrapeRepository extends DoctrineBaseRepository implements GrapeRepository
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
        $country = Grape::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

    public function getAll()
    {
        $query = 'SELECT g FROM Vinci\Domain\Grape\Grape g';
        return $this->_em->createQuery($query)->getResult();
    }

    public function getOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder('g');

        $qb->where('g.slug = :slug');

        $qb->setParameter('slug', $slug);

        $result = $qb->getQuery()->getOneOrNullResult();

        if (! $result) {
            throw new EntityNotFoundException;
        }

        return $result;
    }
}