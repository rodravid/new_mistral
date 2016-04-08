<?php

namespace Vinci\Infrastructure\Datatables;

use Doctrine\ORM\Tools\Pagination\Paginator;

abstract class AbstractDatatables
{

    public abstract function getResultPaginator($perPage, $start, array $order = null, array $search = null);

    public abstract function parseSingleReult($result);

    public function getData($perPage, $start, array $order = null, array $search = null)
    {
        $paginator = $this->getResultPaginator($perPage, $start, $order, $search);

        $data = [];

        foreach ($paginator->getIterator() as $result) {
            $data[] = $this->parseSingleReult($result);
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

    protected function buildActionsColumn(array $params = [])
    {
        return '<div class="btn-group btn-group-xs">
                <a href="' . $params['edit_url'] . '" class="btn btn-default"><i class="fa fa-edit"></i> Editar</a>
                <a href="javascript:void(0);" class="btn btn-danger"
                   data-form-link
                   data-confirm-title="Confirmação de exclusão"
                   data-confirm-text="Deseja realmente excluir esse registro?"
                   data-method="DELETE"
                   data-action="' . $params['destroy_url'] . '"><i class="fa fa-trash"></i> Excluir</a>
            </div>';
    }

    protected function makePaginator($query, $fetchJoinCollection = true)
    {
        return new Paginator($query, $fetchJoinCollection);
    }

}