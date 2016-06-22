<?php

namespace Vinci\Infrastructure\Product;

use Doctrine\ORM\Query\Expr\Join;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Product\Notify\ProductNotify;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionInterface;
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

    public function getOneById($id)
    {
        $product = $this->find($id);

        if (! $product) {
            throw new EntityNotFoundException;
        }

        return $product;
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
        $doctrineConfig = $this->_em->getConfiguration();
        $doctrineConfig->addCustomStringFunction('FIELD', 'DoctrineExtensions\Query\Mysql\Field');

        $qb = $this->getBaseQueryBuilder();

        $qb->addSelect("field(p.id, " . implode(", ", $productsIds) . ") as HIDDEN field");

        $qb->where($qb->expr()->in('p.id', $productsIds))
            ->orderBy('field');

        return $qb->getQuery()->getResult();
    }

    public function getProductsForIndexing()
    {
        $qb = $this->createQueryBuilder('p');

        $qb->join('p.variants', 'v')
            ->join('v.prices', 'vp')
            ->where('v.stock > 0')
            ->andWhere('vp.price > 0');

        return $qb->getQuery()->getResult();
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

    public function getFavoriteProductsByCustomer(CustomerInterface $customer, $perPage = 12, $keyword = null, $pageName = 'page')
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->join('p.customers', 'cs')
            ->where($qb->expr()->eq('cs.id', $customer->getId()));

        if (! empty($keyword)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('v.title', ':search')
            ));

            $qb->setParameter('search', '%' . $keyword . '%');
        }

        return $this->paginate($qb->getQuery(), $perPage, $pageName);
    }

    public function getFavoritesProductsIdsByCustomer(CustomerInterface $customer)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->select('p.id')
            ->join('p.customers', 'cs')
            ->where($qb->expr()->eq('cs.id', $customer->getId()));

        $result = $qb->getQuery()->getArrayResult();

        $ids = array_column($result, 'id');

        return array_combine($ids, $ids);
    }

    public function getProductsByShowcase($showcase, $perPage = 10, $currentPage = 1, $path = '/')
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->join('Vinci\Domain\Showcase\ShowcaseItem', 'si', Join::WITH, 'si.product = p')
            ->join('Vinci\Domain\Showcase\Showcase', 's', Join::WITH, 'si.showcase = s')
            ->where('s.id = :id')
            ->orderBy('si.position', 'asc');

        $this->applyDefaultConditions($qb);

        $qb->setParameter('id', $showcase);

        return $this->paginateRaw($qb->getQuery(), $perPage, $currentPage, $path);
    }

    public function applyDefaultConditions($queryBuilder)
    {
        $queryBuilder->andWhere('vp.price > 0')
            ->andWhere('v.stock > 0');
    }

    public function countProducts()
    {
        return (int) $this->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }

    public function getLastProducts($perPage, $currentPage = 1)
    {
        $query = $this->createQueryBuilder('p')
                    ->select('p')
                    ->orderBy('p.id', 'desc')
                    ->getQuery();

        return $this->paginateRaw($query, $perPage, $currentPage);
    }

    public function registerNotify($data)
    {
        $data['product'] = $this->find($data['product']);

        $productNotify = ProductNotify::make($data);

        $this->_em->persist($productNotify);
        $this->_em->flush();
    }

    public function hasntRegisteredYet($data)
    {
        $query = $this->createQueryBuilder('pn');

        $query = $query->where('product', '=', $data['product'])
                       ->where('customer_email', '=', $data['customer_email']);

        $productNotify = $query->getQuery();

        dd($productNotify);
    }

    public function getProductsIdsFromPromotion(DiscountPromotionInterface $promotion)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->select('p.id')
            ->join('Vinci\Domain\Promotion\PromotionItem', 'pi', Join::WITH, 'pi.product = p')
            ->where('pi.promotion = :promotionId');

        $qb->setParameter('promotionId', $promotion->getId());

        $result = $qb->getQuery()->getArrayResult();

        $ids = array_column($result, 'id');

        return array_combine($ids, $ids);
    }
}