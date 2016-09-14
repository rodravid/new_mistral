<?php

namespace Vinci\Infrastructure\Common;

use Illuminate\Contracts\Pagination\Presenter;
use Illuminate\Pagination\LengthAwarePaginator;

class LengthAwarePaginatorCustom extends LengthAwarePaginator
{

    public function links(Presenter $presenter = null)
    {
        return preg_replace('/\%5B([0-9])\%5D/', '%5B%5D', parent::links($presenter));
    }

}