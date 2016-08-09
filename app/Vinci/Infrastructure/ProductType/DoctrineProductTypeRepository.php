<?php

namespace Vinci\Infrastructure\ProductType;

use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\ProductType\ProductTypeRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineProductTypeRepository extends DoctrineBaseRepository implements ProductTypeRepository
{

    public function getAll()
    {
        $queryBuilder = $this->createQueryBuilder('pt');

        $queryBuilder->select('pt');

        return $queryBuilder->getQuery()->getResult();
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
        $country = ProductType::make($data);
        $this->_em->persist($country);
        $this->_em->flush();
        return $country;
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

    public function getOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder('pt');

        $qb->where('pt.slug = :slug');

        $qb->setParameter('slug', $slug);

        $result = $qb->getQuery()->getOneOrNullResult();

        if (! $result) {
            throw new EntityNotFoundException;
        }

        return $result;
    }
}