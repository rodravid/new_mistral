<?php

namespace Vinci\Domain\Order\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;
use Vinci\Domain\Order\OrderInterface;

class OrderPresenter extends AbstractPresenter
{

    public function presentItemsTotal()
    {
        return $this->toRealCurrency($this->getItemsTotal());
    }

    public function presentStatus()
    {
        switch ($this->getStatus()) {
            case OrderInterface::STATUS_NEW:
                return 'Aguardando pagamento';
                break;
        }
    }

    public function presentCreationDate()
    {
        return $this->toDefaultDate($this->getCreatedAt());
    }

}