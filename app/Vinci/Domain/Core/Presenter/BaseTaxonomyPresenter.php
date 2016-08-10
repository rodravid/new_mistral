<?php

namespace Vinci\Domain\Core\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class BaseTaxonomyPresenter extends AbstractPresenter
{

    public function presentWebUrl()
    {
        return $this->getWebUrl();
    }

}