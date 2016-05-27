<?php

namespace Vinci\Domain\Payment\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class PaymentPresenter extends AbstractPresenter
{

    public function presentInstallmentText()
    {
        return sprintf('%dx de %s', $this->getInstallments(), $this->installment_amount);
    }

    public function presentInstallmentAmount()
    {
        return $this->toRealCurrency($this->getInstallmentAmount());
    }

}