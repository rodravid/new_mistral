<?php

namespace Vinci\Domain\Search\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class FilterPresenter extends AbstractPresenter
{

    public function presentTitle()
    {
        return $this->getTitle();
    }

    public function presentName()
    {
        return $this->getName();
    }

}