<?php

namespace Vinci\Infrastructure\Region\Datatables;

use Vinci\App\Cms\Http\Region\Presenters\RegionPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Region\RegionRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class RegionCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, RegionRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        2 => 'o.name',
        3 => 'c.name',
        4 => 'o.createdAt',
        5 => 'o.visibleSite',
        6 => 'o.status'
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->leftJoin('o.user', 'u')
            ->leftJoin('o.images', 'i')
            ->leftJoin('o.country', 'c')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search'),
                $qb->expr()->like('c.name', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($region)
    {

        $presenter = new RegionPresenter($region);

        return [
            $presenter->getId(),
            $presenter->image_html,
            $presenter->name,
            $presenter->country_link,
            $presenter->created_at,
            $presenter->visible_site,
            $presenter->status_html,
            $this->buildActionsColumn($region)
        ];
    }

}