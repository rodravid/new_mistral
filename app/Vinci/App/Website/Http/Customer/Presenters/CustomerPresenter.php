<?php

namespace Vinci\App\Website\Http\Customer\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class CustomerPresenter extends AbstractPresenter
{

    public function presentFirstName()
    {
        return explode(' ', $this->getName())[0];
    }

    public function presentSalutation()
    {
        return sprintf('Seja %s, %s!', $this->getGender() == 'M' ? 'bem-vindo' : 'bem-vinda', $this->presentFirstName());
    }

}