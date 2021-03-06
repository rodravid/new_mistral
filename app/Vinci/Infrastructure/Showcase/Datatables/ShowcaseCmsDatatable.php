<?php

namespace Vinci\Infrastructure\Showcase\Datatables;

use Vinci\App\Cms\Http\Showcase\Presenters\ShowcasePresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class ShowcaseCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, ShowcaseRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'n.id',
        1 => 'n.position',
        2 => 'n.title',
        3 => 'n.createdAt',
        4 => 'n.startsAt',
        5 => 'n.expirationAt',
        6 => 'n.status',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->getBySortableGroupsQueryBuilder(['type' => $this->aclService->getCurrentModuleName()])
            ->join('n.user', 'u')
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

    public function parseSingleResult($highlight)
    {
        $presenter = new ShowcasePresenter($highlight);

        return [
            $presenter->id,
            $presenter->position,
            $presenter->title,
            $presenter->created_at,
            $presenter->starts_at,
            $presenter->expiration_at,
            $presenter->status_html,
            $this->buildActionsColumn($highlight)
        ];
    }

}