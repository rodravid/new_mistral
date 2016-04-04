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

}