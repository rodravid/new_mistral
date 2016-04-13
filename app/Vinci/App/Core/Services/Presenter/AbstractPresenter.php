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

    public function presentCreatedAt()
    {
        return $this->toDefaultDateTime($this->getCreatedAt());
    }

    public function presentUpdatedAt()
    {
        return $this->toDefaultDateTime($this->getUpdatedAt());
    }

    protected function toDefaultDateTime($date)
    {
        if (! empty($date) && $date instanceof Carbon) {
            return  $date->format('d/m/Y \à\s H:i\h');
        }
    }

}