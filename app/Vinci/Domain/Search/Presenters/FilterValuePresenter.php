<?php

namespace Vinci\Domain\Search\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class FilterValuePresenter extends AbstractPresenter
{

    public function presentTitle()
    {
        return $this->getTitle();
    }

    public function presentCount()
    {
        return $this->getCount();
    }

}