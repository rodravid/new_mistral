<?php

namespace Vinci\Infrastructure\ACL\Roles\Datatables;

use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\ACL\Role\RoleRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class RolesCmsDatatable extends AbstractDatatables
{

    protected $roleRepository;

    public function __construct(ACLService $aclService, RoleRepository $roleRepository)
    {
        parent::__construct($aclService);

        $this->roleRepository = $roleRepository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'o.title',
        2 => 'o.description',
        3 => 'o.createdAt',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->roleRepository->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search'),
                $qb->expr()->like('o.title', ':search'),
                $qb->expr()->like('o.description', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($role)
    {
        $result = [
            $role->getId(),
            $role->getTitle(),
            $role->getDescription(),
            $role->getCreatedAt()->format('d/m/Y H:i:s'),
        ];

        if ($role->isSuperAdmin()) {
            $result[] = '';
        } else {
            $result[] = $this->buildActionsColumn($role);
        }

        return $result;
    }

}