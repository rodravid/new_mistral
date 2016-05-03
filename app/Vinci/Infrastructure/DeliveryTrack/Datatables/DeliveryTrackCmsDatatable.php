<?php

namespace Vinci\Infrastructure\DeliveryTrack\Datatables;

use Vinci\App\Cms\Http\DeliveryTrack\Presenters\DeliveryTrackPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\DeliveryTrack\DeliveryTrackRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class DeliveryTrackCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, DeliveryTrackRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'o.title',
        2 => 'u.name',
        3 => 'o.createdAt',
        4 => 'o.status'
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->leftJoin('o.user', 'u')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.title', ':search'),
                $qb->expr()->like('u.name', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($deliveryTrack)
    {
        $presenter = new DeliveryTrackPresenter($deliveryTrack);

        return [
            $presenter->id,
            $presenter->title,
            $presenter->user_name,
            $presenter->created_at,
            $presenter->status_html,
            $this->buildActionsColumn($deliveryTrack)
        ];
    }

}