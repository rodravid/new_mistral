<?php

namespace Vinci\Infrastructure\Promotion\Datatables;

use Vinci\App\Cms\Http\Promotion\DiscountPromotion\Presenters\PromotionItemPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Promotion\PromotionRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class PromotionProductsCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, PromotionRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'p.id',
        1 => 'v.sku',
        2 => 'v.title',
        3 => 'v.stock',
        4 => 'i.createdAt',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {

        $qb = $this->repository->getItemsQueryBuilder('i')
            ->join('i.promotion', 'prm')
            ->join('i.product', 'p')
            ->join('p.variants', 'v')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        $qb->andWhere($qb->expr()->eq('prm.id', array_get($search, 'promotion.id')));

        if (! empty($search['value'])) {

            $qb->andWhere($qb->expr()->eq('v.sku', ':id'));

            $qb->orWhere($qb->expr()->eq('p.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('v.title', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($item)
    {
        $presenter = new PromotionItemPresenter($item);

        return [
            sprintf('<a href="%s">%s</a>', route('cms.products.edit', $presenter->product->id), $presenter->product->id),
            $presenter->product->sku,
            $presenter->product->title,
            $presenter->product->stock,
            $presenter->created_at,
            $this->buildActionsColumn($item)
        ];
    }

    protected function buildActionsColumn(Model $entity, array $params = [])
    {
        $actions = '<div class="btn-group btn-group-xs">';

        $actions .= '<a href="javascript:void(0);" class="btn btn-danger"
               data-remove-item
               data-confirm-title="Confirmação de remoção"
               data-confirm-text="Deseja realmente remover esse registro?"
               data-method="DELETE"
               data-action="' . route('cms.discount-promotion.edit#remove-item', [$entity->promotion->id, $entity->id]) . '"><i class="fa fa-minus-circle"></i> Remover</a>';

        $actions .= '</div>';

        return $actions;
    }

}