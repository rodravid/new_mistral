<?php

namespace Vinci\Infrastructure\Product;

use Doctrine\ORM\Query\Expr\Join;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Product\Notify\ProductNotify;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionInterface;
use Vinci\Domain\Search\Product\ProductRepositoryInterface as ProductRepositoryIndexer;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineProductRepository extends DoctrineBaseRepository implements ProductRepository, ProductRepositoryIndexer
{

    public function find($id)
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->where($qb->expr()->eq('p.id', $id));

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
        $qb = $this->getBaseQueryBuilder();

        $qb->where($qb->expr()->eq('p.id', $id))
            ->andWhere($qb->expr()->eq('c.id', $channel));

        return $qb->getQuery()->getOneOrNullResult();
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

    public function getProductsByCountryAndType(Country $country, ProductType $type, array $except = [])
    {
        $qb = $this->getBaseQueryBuilder();

        $qb->where('p.productType = :type')
           ->andWhere('p.country = :country')
           ->andWhere('v.stock > 0')
           ->andWhere('vp.price > 0');

        $qb->setParameter('type', $type->getId())
           ->setParameter('country', $country->getId());

        if (! empty($except)) {
            $qb->andWhere($qb->expr()->notIn('p.id', $except));
        }

        return $this->paginateRaw($qb->getQuery(), 4);
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

    public function getAllValidForSelectArray()
    {
        $qb = $this->getBaseQueryBuilder();

        $qb
            ->where('v.stock > 0')
            ->andWhere('vp.price > 0');

        $qb->select('p.id as id', 'CONCAT( CONCAT(v.sku, \' - \'),  v.title) as text');

        $result = $qb->getQuery()->getArrayResult();

        $products = [];

        foreach ($result as $p) {
            $products[$p['id']] = $p['text'];
        }

        return $products;
    }

    public function getProductsFromCountries(array $countries)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->join('p.country', 'c')
            ->where($qb->expr()->in('c.id', $countries));

        return $qb->getQuery()->getResult();
    }

    public function getProductsFromRegions(array $regions)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->join('p.region', 'r')
            ->where($qb->expr()->in('r.id', $regions));

        return $qb->getQuery()->getResult();
    }

    public function getProductsFromProducers(array $producers)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->join('p.producer', 'pr')
            ->where($qb->expr()->in('pr.id', $producers));

        return $qb->getQuery()->getResult();
    }

    public function getProductsFromTypes(array $types)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->join('p.productType', 'pt')
            ->where($qb->expr()->in('pt.id', $types));

        return $qb->getQuery()->getResult();
    }
}