<?php

namespace Vinci\App\Website\Http\Checkout\Presenters;

use Vinci\Domain\Customer\Address\AddressPresenter as BaseAddressPresenter;

class AddressPresenter extends BaseAddressPresenter
{

    public function presentAddressHtml()
    {
        return
            "<p>{$this->public_place} {$this->address}, {$this->number}, {$this->city_name}</p>
             <p>{$this->state_name} - {$this->uf}</p>
             <p>CEP {$this->postal_code}</p>";
    }

}