<?php

namespace Vinci\Infrastructure\Newsletter\Datatables;

use Vinci\App\Cms\Http\Newsletter\Presenters\NewsletterPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Newsletter\NewsletterRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class NewsletterCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, NewsletterRepository $repository)
    {
        parent::__construct($aclService);

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

    public function parseSingleResult($newsletter)
    {

        $presenter = new NewsletterPresenter($newsletter);

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