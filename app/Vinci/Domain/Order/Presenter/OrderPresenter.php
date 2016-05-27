<?php

namespace Vinci\Domain\Order\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class OrderPresenter extends AbstractPresenter
{

    public function presentItemsTotal()
    {
        return $this->toRealCurrency($this->getItemsTotal());
    }

}