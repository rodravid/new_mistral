<?php

namespace Vinci\Infrastructure\Highlight\Datatables;

use Vinci\App\Cms\Http\Highlight\Presenters\HighlightPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class HighlightCmsDatatable extends AbstractDatatables
{

    protected $adminRepository;

    protected $ACLService;

    public function __construct(HighlightRepository $adminRepository, ACLService $ACLService)
    {
        $this->adminRepository = $adminRepository;
        $this->ACLService = $ACLService;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'p.id',
        2 => 'o.name',
        3 => 'o.email',
        4 => 'r.title',
        5 => 'o.createdAt',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->adminRepository->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search'),
                $qb->expr()->like('o.email', ':search'),
                $qb->expr()->like('r.title', ':search')
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
            '<img src="' . $presenter->profile_photo . '" style="width: 50px;" />',
            $highlight->getName(),
            $highlight->getEmail(),
            $presenter->group_name,
            $presenter->created_at,
            $this->buildActionsColumn([
                'edit_url' => route('cms.users.edit', $highlight->getId()),
                'destroy_url' => route('cms.users.destroy', $highlight->getId())
            ])
        ];
    }

}