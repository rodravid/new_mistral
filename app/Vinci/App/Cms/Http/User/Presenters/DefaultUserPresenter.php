<?php

namespace Vinci\App\Cms\Http\User\Presenters;

use Robbo\Presenter\Presenter;

class DefaultUserPresenter extends Presenter
{

    public function presentOffice()
    {
        if (! empty($office = $this->getOffice())) {
            return ' - ' . $office;
        }
    }

    public function presentMemberSinceDate()
    {
        return $this->getCreatedAt()->formatLocalized("%b/%Y");
    }

}