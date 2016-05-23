<?php

namespace Vinci\Domain\ShoppingCart\Item;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShoppingCartItemPresenter extends AbstractPresenter
{

    public function presentQuantityUnits()
    {
        $quantity = $this->getQuantity();

        if ($quantity == 1) {
            return '1 unidade';
        }

        return sprintf('%s unidades', $quantity);
    }

    public function presentSubtotal()
    {
        return $this->toRealCurrency($this->getSubtotal());
    }

}