<?php

namespace Vinci\Infrastructure\Dollar\Datatables;

use Vinci\App\Cms\Http\Dollar\Presenters\DollarPresenter;
use Vinci\Domain\Dollar\DollarRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class DollarCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(DollarRepository $repository)
    {
        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'o.name',
        2 => 'o.email',
        3 => 'o.accept_promotions',
        4 => 'o.accept_events',
        5 => 'o.createdAt',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search'),
                $qb->expr()->like('o.email', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($dollar)
    {
        $presenter = new DollarPresenter($dollar);

        return [
            $presenter->getId(),
            $presenter->getName(),
            $presenter->getEmail(),
            $presenter->accept_promotions,
            $presenter->accept_events,
            $presenter->created_at
        ];
    }

}