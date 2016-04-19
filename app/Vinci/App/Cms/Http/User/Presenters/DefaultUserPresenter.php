<?php

namespace Vinci\App\Cms\Http\User\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class DefaultUserPresenter extends AbstractPresenter
{

    public function presentOffice()
    {
        if (! empty($office = $this->getOffice())) {
            return ' - ' . $office;
        }
    }

    public function presentProfilePhoto()
    {
        if ($this->hasProfilePhoto()) {
            return $this->getProfilePhoto()->getWebPath();
        }

        return $this->getDefaultProfilePhoto();
    }

    public function presentGroupName()
    {
        return $this->getRoles()->first()->getTitle();
    }

    protected function getDefaultProfilePhoto()
    {
        return asset_cms('dist/img/profile-no-photo.png');
    }

}