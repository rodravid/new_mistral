<?php

namespace Vinci\Domain\Order\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class OrderPresenter extends AbstractPresenter
{

    public function presentItemsTotal()
    {
        return $this->toRealCurrency($this->getItemsTotal());
    }

    public function presentStatus()
    {
        return $this->getTrackingStatus()->getTitle();
    }

    public function presentCreationDate()
    {
        return $this->toDefaultDate($this->getCreatedAt());
    }

    public function presentShippingAddress()
    {
        return $this->getShippingAddress();
    }

    public function presentErpNumber()
    {
        return $this->getErpNumber();
    }

    public function presentPrintStatus()
    {
        if ($this->getPrinted()) {
            return '<span class="badge bg-green">Sim</span>';
        }

        return '<span class="badge bg-grey">Não</span>';

    }

}