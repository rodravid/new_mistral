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

}