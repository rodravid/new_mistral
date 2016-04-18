<?php

namespace Vinci\App\Cms\Http\Newsletter\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class NewsletterPresenter extends AbstractPresenter
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