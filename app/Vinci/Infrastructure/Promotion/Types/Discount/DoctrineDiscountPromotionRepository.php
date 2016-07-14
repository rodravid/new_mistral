<?php

namespace Vinci\Infrastructure\Promotion\Types\Discount;

use Cache;
use Carbon\Carbon;
use Doctrine\ORM\Query\Expr\Join;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionRepository;
use Vinci\Domain\Showcase\Showcase;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineDiscountPromotionRepository extends DoctrineBaseRepository implements DiscountPromotionRepository
{
    public function lists($type, $max = 4)
    {
        $qb = $this->getBySortableGroupsQueryBuilder(['type' => $type]);

        $qb->andWhere($qb->expr()->lte('n.startsAt', $qb->expr()->literal(Carbon::now())))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->gte('n.expirationAt', $qb->expr()->literal(Carbon::now())),
                $qb->expr()->isNull('n.expirationAt')
            ))
            ->andWhere($qb->expr()->eq('n.status', Status::ACTIVE));

        $qb->setMaxResults($max);

        return $qb->getQuery()->getResult();
    }

    public function find($id)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->select('o')
            ->where($qb->expr()->eq('o.id', $id));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(array $data)
    {
        $showcase = Showcase::make($data);
        $this->_em->persist($showcase);
        $this->_em->flush();
        return $showcase;
    }

    public function getItems($showcaseId)
    {

    }

    public function getItemsQueryBuilder($alias)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select($alias)
            ->from('Vinci\Domain\Showcase\ShowcaseItem', $alias);

        return $qb;
    }

    public function getOneById($id)
    {
        $showcase = $this->find($id);

        if (! $showcase) {
            throw new EntityNotFoundException;
        }

        return $showcase;
    }

    public function findOneByProduct(ProductInterface $product)
    {
        $qb = $this->createQueryBuilder('dp');

        $qb
            ->select('dp')
            ->join('dp.items', 'i')
            ->join('i.product', 'p')
            ->where($qb->expr()->eq('p.id', $product->getId()))
            ->andWhere($qb->expr()->eq('dp.status', Status::ACTIVE))
            ->andWhere($qb->expr()->lte('dp.startsAt', $qb->expr()->literal(Carbon::now())))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->gte('dp.expirationAt', $qb->expr()->literal(Carbon::now())),
                $qb->expr()->isNull('dp.expirationAt')
            ))->orderBy('dp.startsAt', 'DESC');

        $result = $qb->getQuery()->getResult();

        if (! empty($result)) {
            return $result[0];
        }
    }

    public function save($entity)
    {
        parent::save($entity);

        Cache::tags('showcase')->flush();
    }

}