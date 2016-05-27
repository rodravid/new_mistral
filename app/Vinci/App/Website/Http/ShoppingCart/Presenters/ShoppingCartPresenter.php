<?php

namespace Vinci\App\Website\Http\ShoppingCart\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShoppingCartPresenter extends AbstractPresenter
{

    public function presentTotal()
    {
        return $this->toRealCurrency($this->getTotal());
    }

}