<?php

namespace Vinci\App\Cms\Http\Newsletter\Presenters;

use Robbo\Presenter\Presenter;

class NewsletterPresenter extends Presenter
{

    public function presentCreatedAt()
    {
        return $this->getCreatedAt()->format('d/m/Y H:i:s');
    }

}