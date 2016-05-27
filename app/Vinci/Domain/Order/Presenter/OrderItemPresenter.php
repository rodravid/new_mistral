<?php

namespace Vinci\Domain\Order\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class OrderItemPresenter extends AbstractPresenter
{

    public function presentProduct()
    {
        return $this->getProductVariant();
    }

    public function presentTotal()
    {
        return $this->toRealCurrency($this->getTotal());
    }

}