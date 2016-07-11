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

    public function presentFullAddressHtml()
    {
        $mainAddress = $this->getMainAddress();

        if ($mainAddress) {

            return "
                 {$mainAddress->public_place} 
                 {$mainAddress->address},  
                 n° {$mainAddress->number} <br />
                 <b>Complemento:</b> {$mainAddress->complement} <br>
                 <b>Bairro:</b> {$mainAddress->district }<br>
                 <b>Cidade: </b>  {$mainAddress->city_name} <br>
                 <b>CEP: </b> {$mainAddress->postal_code}<br />
                 <b>Estado: </b> {$mainAddress->state_name} - {$mainAddress->uf} <br>
                 
                 <b>Brasil: </b>{$mainAddress->country_name} <br>";
        }

    }

}