<?php

namespace Vinci\Infrastructure\Promotion\Types\Discount\Datatables;

use Vinci\App\Cms\Http\Promotion\DiscountPromotion\Presenters\DiscountPromotionPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class DiscountPromotionCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, DiscountPromotionRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'p.id',
        1 => 'p.position',
        2 => 'p.title',
        3 => 'p.createdAt',
        4 => 'p.startsAt',
        5 => 'p.expirationAt',
        6 => 'p.status',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->join('p.user', 'u')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->andWhere($qb->expr()->eq('n.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('n.title', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($promotion)
    {
        $presenter = new DiscountPromotionPresenter($promotion);

        return [
            $presenter->id,
            $presenter->title,
            $presenter->user_name,
            $presenter->created_at,
            $presenter->starts_at,
            $presenter->expiration_at,
            $presenter->status_html,
            $this->buildActionsColumn($promotion)
        ];
    }

}