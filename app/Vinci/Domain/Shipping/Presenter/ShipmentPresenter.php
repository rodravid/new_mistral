<?php

namespace Vinci\Domain\Shipping\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShipmentPresenter extends AbstractPresenter
{

    public function presentAmount()
    {
        if ($this->getAmount() > 0) {
            return $this->toRealCurrency($this->getAmount());
        }

        return 'Grátis';
    }

    public function presentDeadline()
    {
        if ($this->getDeadline() > 1) {
            return $this->getDeadline() . " dias úteis";
        }

        return $this->getDeadline() . " dia útil";
    }

}