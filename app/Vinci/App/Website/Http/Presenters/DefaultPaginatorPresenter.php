<?php

namespace Vinci\App\Website\Http\Presenters;

use IteratorAggregate;
use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class DefaultPaginatorPresenter extends AbstractPresenter implements IteratorAggregate
{

    public function presentRangeView()
    {
        $page = $this->currentPage();
        $perPage = $this->perPage();
        $total = $this->total();

        if ($page == 1) {
            $start = $page;
            $end = min($perPage, $total);

        } else {
            $start = (($page - 1) * $perPage) + 1;
            $end = min($page * $perPage, $total);
        }

        return sprintf('%s - %s de %s', $start, $end, $total);
    }

    public function getIterator()
    {
        return $this->getObject()->getIterator();
    }
}