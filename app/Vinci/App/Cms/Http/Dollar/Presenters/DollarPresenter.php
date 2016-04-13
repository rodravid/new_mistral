<?php

namespace Vinci\App\Cms\Http\Dollar\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class DollarPresenter extends AbstractPresenter
{

    public function presentAcceptPromotions()
    {
        return $this->toAffirmative($this->getAcceptPromotions());
    }

    public function presentAcceptEvents()
    {
        return $this->toAffirmative($this->getAcceptEvents());
    }

}