<?php

namespace Vinci\App\Website\Http\Order\Presenter;

use Vinci\Domain\Order\Presenter\OrderPresenter as BaseOrderPresenter;

class OrderPresenter extends BaseOrderPresenter
{

    public function presentCreationDate()
    {
        return $this->toDefaultDate($this->getCreatedAt());
    }

}