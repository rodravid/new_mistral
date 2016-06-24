<?php

namespace Vinci\Domain\Payment\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class PaymentMethodPresenter extends AbstractPresenter
{

    public function presentIconImageUrl()
    {
        return asset_web('images/payment_methods/icon_' . $this->getName() . '.png');
    }

}