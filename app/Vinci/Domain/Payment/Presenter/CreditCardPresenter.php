<?php

namespace Vinci\Domain\Payment\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class CreditCardPresenter extends AbstractPresenter
{

    public function presentExpiryDate()
    {
        return str_pad($this->getExpiryMonth(), 2, '0', STR_PAD_LEFT) . '/' . $this->getExpiryYear();
    }

}