<?php

namespace Vinci\Infrastructure\Datatables;

abstract class AbstractDatatables
{

    public abstract function getData($perPage, $start, array $order = null, array $search = null);

    public function makeDatatablesOutput($total, array $data)
    {
        return [
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => $data
        ];
    }

    protected function getActionsColumn($entity, array $params = [])
    {
        return '<div class="btn-group btn-group-xs">
                    <a href="/cms/users/' . $entity->getId() . '/edit" class="btn btn-default"><i class="fa fa-edit"></i> Editar</a>
                    <a href="javascript:void(0);" class="btn btn-danger"
                       data-form-link
                       data-confirm-title="Confirmação de exclusão"
                       data-confirm-text="Deseja realmente excluir esse registro?"
                       data-method="DELETE"
                       data-action="' . $params['destroy_url'] . '"><i class="fa fa-trash"></i> Excluir</a>

                </div>';
    }

}