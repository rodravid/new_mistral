<?php

namespace Vinci\Infrastructure\Producer\Datatables;

use Vinci\App\Cms\Http\Producer\Presenters\ProducerPresenter;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class ProducerCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ProducerRepository $repository)
    {
        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        2 => 'o.name',
        3 => 'o.createdAt',
        4 => 'o.visibleSite',
        5 => 'o.status'
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->leftJoin('o.user', 'u')
            ->leftJoin('o.images', 'i')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($producer)
    {

        $presenter = new ProducerPresenter($producer);

        return [
            $presenter->getId(),
            $presenter->image_html,
            $presenter->getName(),
            $presenter->created_at,
            $presenter->visible_site,
            $presenter->status_html,
            $this->buildActionsColumn([
                'edit_url' => route('cms.producers.edit', $producer->getId()),
                'destroy_url' => route('cms.producers.destroy', $producer->getId())
            ])
        ];
    }

}