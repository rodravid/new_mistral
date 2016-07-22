<?php

namespace Vinci\Domain\Search\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class FilterValuePresenter extends AbstractPresenter
{

    public function presentTitle()
    {
        
        if ($this->getFilter()->getName() == 'preco') {
            return $this->getPriceFilterValueTitle($this->getTitle());
        }

        return $this->getTitle();
    }

    public function presentCount()
    {
        return $this->getCount();
    }

    protected function getPriceFilterValueTitle($title)
    {
        return get_filter_price_value_title($title);
    }

}