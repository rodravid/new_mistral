<?php

namespace Vinci\Infrastructure\Promotion\Datatables;

use Vinci\App\Cms\Http\Showcase\Presenters\ShowcaseItemPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class PromotionProductsCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, ShowcaseRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'v.sku',
        1 => 'v.title',
        2 => 'i.position',
        3 => 'i.createdAt',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->getItemsQueryBuilder('i')
            ->join('i.showcase', 's')
            ->join('i.product', 'p')
            ->join('p.variants', 'v')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        $qb->where($qb->expr()->eq('s.id', array_get($search, 'showcase.id')));

        if (! empty($search['value'])) {

            $qb->andWhere($qb->expr()->eq('v.sku', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('v.title', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($showcaseItem)
    {
        $presenter = new ShowcaseItemPresenter($showcaseItem);

        return [
            $presenter->product->sku,
            $presenter->product->title,
            sprintf('<p class="field-editable" data-id="%s">%s</p>', $presenter->id, $presenter->position),
            $presenter->created_at,
            $this->buildActionsColumn($showcaseItem)
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
               data-action="' . route('cms.home-showcases.edit#remove-item', [$entity->showcase->id, $entity->id]) . '"><i class="fa fa-minus-circle"></i> Remover</a>';

        $actions .= '</div>';

        return $actions;
    }

}