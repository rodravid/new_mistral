<?php

namespace Vinci\Infrastructure\Admin\Datatables;

use Vinci\App\Cms\Http\User\Presenters\DefaultUserPresenter;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class UsersCmsDatatable extends AbstractDatatables
{

    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
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
            ->select('o', 'r', 'p')
            ->join('o.roles', 'r')
            ->leftJoin('o.profile_photo', 'p')
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

    public function parseSingleResult($user)
    {

        $presenter = new DefaultUserPresenter($user);

        return [
            $user->getId(),
            '<img src="' . $presenter->profile_photo . '" style="width: 50px;" />',
            $user->getName(),
            $user->getEmail(),
            $presenter->group_name,
            $presenter->created_at,
            $this->buildActionsColumn([
                'edit_url' => route('cms.users.edit', $user->getId()),
                'destroy_url' => route('cms.users.destroy', $user->getId())
            ])
        ];
    }

}