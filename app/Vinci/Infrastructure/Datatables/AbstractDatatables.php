<?php

namespace Vinci\Infrastructure\Datatables;

use Doctrine\ORM\Tools\Pagination\Paginator;
use LaravelDoctrine\ACL\Contracts\HasPermissions;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Model;

abstract class AbstractDatatables
{

    protected $aclService;

    public function __construct(ACLService $aclService)
    {
        $this->aclService = $aclService;
    }

    public abstract function getResultPaginator($perPage, $start, array $order = null, array $search = null);

    public abstract function parseSingleResult($result);

    public function getData($perPage, $start, array $order = null, array $search = null)
    {
        $paginator = $this->getResultPaginator($perPage, $start, $order, $search);

        $data = [];

        foreach ($paginator->getIterator() as $result) {
            $data[] = $this->parseSingleResult($result);
        }

        return $this->makeDatatablesOutput($paginator->count(), $data);
    }

    public function makeDatatablesOutput($total, array $data)
    {
        return [
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => $data
        ];
    }

    public function applyOrder(array $order, $builder)
    {
        $direction = $order['dir'];
        $collumn = $this->sortMapping[$order['column']];

        $builder->orderBy($collumn, $direction);
    }

    protected function buildActionsColumn(Model $entity, array $params = [])
    {
        $actions = '<div class="btn-group btn-group-xs">';

        if ($this->checkEditPermission(cmsUser())) {
            $actions .= '<a href="' . route($this->getEditRouteName(), [$entity->getId()]) . '" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a>';
        }

        if ($this->checkDestroyPermission(cmsUser())) {
            $actions .= '<a href="javascript:void(0);" class="btn btn-danger"
                   data-form-link
                   data-confirm-title="Confirmação de exclusão"
                   data-confirm-text="Deseja realmente excluir esse registro?"
                   data-method="DELETE"
                   data-action="' . route($this->getDestroyRouteName(), [$entity->getId()]) . '"><i class="fa fa-trash"></i> Excluir</a>';
        }

        $actions .= '</div>';

        return $actions;
    }

    protected function makePaginator($query, $fetchJoinCollection = true)
    {
        return new Paginator($query, $fetchJoinCollection);
    }

    protected function getEditPermissionName()
    {
        return 'cms.' . $this->aclService->getCurrentModuleName() . '.edit';
    }

    protected function getDestroyPermissionName()
    {
        return 'cms.' . $this->aclService->getCurrentModuleName() . '.destroy';
    }

    protected function getEditRouteName()
    {
        return $this->getEditPermissionName();
    }

    protected function getDestroyRouteName()
    {
        return $this->getDestroyPermissionName();
    }

    protected function checkEditPermission(HasPermissions $user)
    {
        return $user->hasPermissionTo($this->getEditPermissionName());
    }

    protected function checkDestroyPermission(HasPermissions $user)
    {
        return $user->hasPermissionTo($this->getDestroyPermissionName());
    }


}