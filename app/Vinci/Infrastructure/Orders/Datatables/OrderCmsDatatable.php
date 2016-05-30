<?php

namespace Vinci\Infrastructure\Orders\Datatables;

use Vinci\App\Cms\Http\Order\Presenters\OrderPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class OrderCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, OrderRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'o.number',
        2 => 'c.name',
        3 => 'o.total',
        4 => 'o.createdAt',
        5 => 'o.status',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->select('o', 'c')
            ->join('o.customer', 'c')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.number', ':search'),
                $qb->expr()->like('o.total', ':search'),
                $qb->expr()->like('c.name', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($order)
    {

        $presenter = new OrderPresenter($order);

        return [
            $presenter->id,
            $presenter->number,
            $presenter->customer->name,
            $presenter->total,
            $presenter->created_at,
            $presenter->status,
            $this->buildActionsColumn($order)
        ];
    }

    protected function buildActionsColumn(Model $entity, array $params = [])
    {
        $actions = '<div class="btn-group btn-group-xs">';

        if ($this->checkShowPermission(cmsUser())) {
            $actions .= '<a href="' . route($this->getShowRouteName(), [$entity->getId()]) . '" class="btn btn-info"><i class="fa fa-eye"></i> Visualizar</a>';
        }

        $actions .= '</div>';

        return $actions;
    }

}