<?php

namespace Vinci\Domain\Search\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class SearchResultPresenter extends AbstractPresenter
{

    public function presentItems()
    {
        return $this->getItems();
    }

}