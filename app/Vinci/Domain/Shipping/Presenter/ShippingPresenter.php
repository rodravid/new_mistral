<?php

namespace Vinci\Domain\Shipping\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShippingPresenter extends AbstractPresenter
{

    public function presentPrice()
    {
        if ($this->getPrice() > 0) {
            return $this->toRealCurrency($this->getPrice());
        }

        return 'Grátis';
    }

    public function presentDeadline()
    {
        if ($this->getDeadline() > 1) {
            return $this->getDeadline() . " dias úteis para entrega";
        }

        return $this->getDeadline() . " dia útil para entrega";
    }

}