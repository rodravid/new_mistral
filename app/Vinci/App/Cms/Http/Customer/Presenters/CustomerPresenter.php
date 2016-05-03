<?php

namespace Vinci\App\Cms\Http\Customer\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class CustomerPresenter extends AbstractPresenter
{

    public function presentProfilePhoto()
    {
        return $this->getDefaultProfilePhoto();
    }

    protected function getDefaultProfilePhoto()
    {
        return asset_cms('dist/img/profile-no-photo.png');
    }

    public function presentFullAddressHtml()
    {
        $mainAddress = $this->getMainAddress();

        if ($mainAddress) {

            return "<b>CEP: </b> {$mainAddress->postal_code}<br />
                     {$mainAddress->public_place} {$mainAddress->address}, {$mainAddress->number} <br />
                       {$mainAddress->city_name} - {$mainAddress->state_name} / {$mainAddress->uf} - {$mainAddress->country_name}";
        }
    }

    public function presentCustomerType()
    {
        if ($this->isIndividual()) {
            return 'Física';
        }

        return 'Jurídica';
    }

}