<?php

namespace Vinci\Infrastructure\Highlight\Datatables;

use Vinci\App\Cms\Http\Highlight\Presenters\HighlightPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class HighlightCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, HighlightRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'n.id',
        1 => 'n.position',
        2 => 'i.id',
        3 => 'n.title',
        4 => 'n.createdAt',
        5 => 'n.startsAt',
        6 => 'n.expirationAt',
        7 => 'n.status',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->getBySortableGroupsQueryBuilder()
            ->join('n.user', 'u')
            ->leftJoin('n.images', 'i')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        $qb->where($qb->expr()->eq('n.type', ':type'));

        $qb->setParameter('type', $this->ACLService->getCurrentModuleName());

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('n.id', ':id'));

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

        $presenter = new HighlightPresenter($highlight);

        return [
            $highlight->getId(),
            $highlight->position,
            $presenter->image_html,
            $highlight->getTitle(),
            $presenter->created_at,
            $presenter->starts_at,
            $presenter->expiration_at,
            $presenter->status_html,
            $this->buildActionsColumn($highlight)
        ];
    }

}