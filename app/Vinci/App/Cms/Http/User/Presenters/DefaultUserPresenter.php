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

    public function presentProfilePhoto()
    {
        if ($this->hasProfilePhoto()) {
            return $this->getProfilePhoto()->getWebPath();
        }

        return $this->getDefaultProfilePhoto();
    }

    protected function getDefaultProfilePhoto()
    {
        return asset_cms('dist/img/user2-160x160.jpg');
    }

}