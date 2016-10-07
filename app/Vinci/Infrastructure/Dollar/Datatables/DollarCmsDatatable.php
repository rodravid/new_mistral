<?php

namespace Vinci\Infrastructure\Dollar\Datatables;

use Vinci\App\Cms\Http\Dollar\Presenters\DollarPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Dollar\DollarRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class DollarCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, DollarRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'o.description',
        2 => 'o.amount',
        3 => 'u.name',
        4 => 'o.startsAt',
        6 => 'o.createdAt',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->select('o', 'u')
            ->join('o.user', 'u')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.description', ':search'),
                $qb->expr()->like('o.amount', ':search'),
                $qb->expr()->like('u.name', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($dollar)
    {
        $dollar = new DollarPresenter($dollar);

        return [
            $dollar->id,
            $dollar->description,
            $dollar->amount,
            $dollar->user_name,
            $dollar->starts_at,
            $dollar->schedule_status_html,
            $dollar->created_at
        ];
    }

}