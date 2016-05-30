<?php

namespace Vinci\Infrastructure\Product\Datatables;

use Vinci\App\Cms\Http\Product\Presenters\ProductPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class ProductCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, ProductRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'p.id',
        1 => 'v.sku',
        3 => 'v.title',
        4 => 'v.stock',
        5 => 'v.importStock',
        6 => 'v.importPrice',
        7 => 'p.online',
        8 => 'p.createdAt',
        9 => 'p.status',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->select('p')
            ->join('p.variants', 'v')
            ->leftJoin('v.images', 'i')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('p.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->eq('v.sku', ':id'),
                $qb->expr()->like('v.title', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($product)
    {

        $presenter = new ProductPresenter($product);

        return [
            $presenter->id,
            $presenter->sku,
            $presenter->image_html,
            $presenter->title,
            $presenter->stock,
            $presenter->should_import_stock,
            $presenter->should_import_price,
            $presenter->online,
            $presenter->created_at,
            $presenter->status_html,
            $this->buildActionsColumn($product)
        ];
    }

}