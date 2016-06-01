<?php

namespace Vinci\Domain\Product\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ProductPresenter extends AbstractPresenter
{

    public function presentSalePrice()
    {
        return $this->toRealCurrency($this->getSalePrice());
    }

    public function presentWebPath()
    {
        return $this->getWebPath();
    }

}