<?php

namespace Vinci\Domain\ShoppingCart\Item;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShoppingCartItemPresenter extends AbstractPresenter
{

    public function presentSubtotal()
    {
        return $this->toRealCurrency($this->getSubtotal());
    }

}