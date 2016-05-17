<?php

namespace Vinci\App\Website\Http\Customer\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class CustomerPresenter extends AbstractPresenter
{

    public function presentFirstName()
    {
        return explode(' ', $this->getName())[0];
    }

}