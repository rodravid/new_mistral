<?php

namespace Vinci\Infrastructure\Producer;

use Vinci\Domain\Producer\Producer;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineProducerRepository extends DoctrineBaseRepository implements ProducerRepository
{

    public function getAll()
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('producer')
            ->from('Vinci\Domain\Producer\Producer', 'producer')
            ->getQuery();

        return $query->getResult();
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
        $country = Producer::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
    }

    public function getOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.slug = :slug');

        $qb->setParameter('slug', $slug);

        $result = $qb->getQuery()->getOneOrNullResult();

        if (! $result) {
            throw new EntityNotFoundException;
        }

        return $result;
    }

    public function getAllValidForSelectArray()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o.id', 'o.name');

        $result = $qb->getQuery()->getArrayResult();

        $countries = [];

        foreach ($result as $o) {
            $countries[$o['id']] = $o['name'];
        }

        return $countries;
    }
}