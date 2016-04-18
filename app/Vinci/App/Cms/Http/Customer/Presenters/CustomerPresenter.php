<?php

namespace Vinci\App\Cms\Http\Customer\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class CustomerPresenter extends AbstractPresenter
{

    public function presentType()
    {
        if ($this->isIndividual()) {
            return 'Física';
        }

        return 'Jurídica';
    }

}