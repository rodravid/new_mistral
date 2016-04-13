<?php

namespace Vinci\App\Core\Services\Presenter;

use Carbon\Carbon;
use Robbo\Presenter\Presenter as BasePresenter;

abstract class AbstractPresenter extends BasePresenter implements Presentable
{

    protected function toAffirmative($expression)
    {
        return $expression ? 'Sim' : 'Não';
    }

    protected function toDefaultDateTime($date)
    {
        if (! empty($date) && $date instanceof Carbon) {
            return  $date->format('d/m/Y \à\s H:i\h');
        }
    }

    protected function presentAmount()
    {
        return $this->toRealCurrency($this->getAmount());
    }

    protected function toReal($amount)
    {
        return number_format($amount, 2, ',', '.');
    }

    protected function toRealCurrency($amount)
    {
        return 'R$ ' . $this->toReal($amount);
    }

    public function presentCreatedAt()
    {
        return $this->toDefaultDateTime($this->getCreatedAt());
    }

    public function presentUpdatedAt()
    {
        return $this->toDefaultDateTime($this->getUpdatedAt());
    }

    public function presentUserName()
    {
        if ($user = $this->getUser()) {
            return $user->getName();
        }
    }

}