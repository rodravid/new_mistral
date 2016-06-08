<?php

namespace Vinci\App\Core\Services\Datatables;

use Illuminate\Http\Request;

trait DatatablesResponse
{

    public function datatable(Request $request)
    {
        return $this->getDatatable($this->datatable, $request);
    }

    protected function getDatatable($datatable, Request $request)
    {
        return app($datatable)->getData(
            $request->get('length'),
            $request->get('start'),
            $request->get('order')[0],
            $request->get('search')
        );
    }

}