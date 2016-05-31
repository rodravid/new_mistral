<?php

namespace Vinci\Infrastructure\Product;

use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Search\Product\ProductRepositoryInterface as ProductRepositoryIndexer;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineProductRepository extends DoctrineBaseRepository implements ProductRepository, ProductRepositoryIndexer
{

    public function find($id)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p', 'v', 'i', 'vp', 'c', 'a')
            ->join('p.variants', 'v')
            ->leftJoin('p.channels', 'c')
            ->leftJoin('v.images', 'i')
            ->leftJoin('v.prices', 'vp')
            ->leftJoin('p.attributes', 'a')
            ->where($qb->expr()->eq('p.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $highlight = Product::make($data);
        $this->_em->persist($highlight);
        $this->_em->flush();
        return $highlight;
    }

    public function findOneByIdAndChannel($id, $channel)
    {

    }

    public function getOneByTypeAndSlug($type, $slug)
    {
        $qb = $this->getBaseQueryBuilder();

        $qb
            ->where($qb->expr()->isInstanceOf('p', $type))
            ->andWhere('v.slug = :slug');

        $qb->setParameter('slug', $slug);

        $product = $qb->getQuery()->getOneOrNullResult();

        if (! $product) {
            throw new EntityNotFoundException;
        }

        return $product;
    }

    public function getProductsById(array $productsIds)
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->where($qb->expr()->in('p.id', $productsIds));

        return $qb->getQuery()->getResult();
    }

    public function getProductsForIndexing()
    {

        return $this->createQueryBuilder('p')->getQuery();

//        $qb = $this->getBaseQueryBuilder();
//
//        return $qb->getQuery()->getResult();
    }

    public function getBaseQueryBuilder()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'v', 'i', 'vp', 'c', 'av', 'a', 'co', 'pr', 're')
            ->join('p.variants', 'v')
            ->leftJoin('v.images', 'i')
            ->leftJoin('v.prices', 'vp')
            ->leftJoin('p.channels', 'c')
            ->leftJoin('p.attributes', 'av')
            ->leftJoin('av.attribute', 'a')
            ->leftJoin('p.country', 'co')
            ->leftJoin('p.producer', 'pr')
            ->leftJoin('p.region', 're')
        ;

        return $qb;
    }
}