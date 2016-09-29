<?php

namespace Vinci\Domain\Address\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;
use Vinci\App\Core\Utils\Mask;
use Vinci\Domain\Customer\Address\Address as CustomerAddress;
use Vinci\Domain\Order\Address\Address as OrderAddress;

class AddressPresenter extends AbstractPresenter
{

    public function presentPostalCode()
    {
        return mask($this->getPostalCode(), Mask::POSTAL_CODE);
    }

    public function presentCityName()
    {
        return $this->getCity()->getName();
    }

    public function presentStateName()
    {
        return $this->getCity()->getState()->getName();
    }

    public function presentCountryName()
    {
        return $this->getCity()->getState()->getCountry()->getName();
    }

    public function presentUf()
    {
        return $this->getCity()->getState()->getUf();
    }

    public function presentPublicPlace()
    {
        return $this->getPublicPlace()->getTitle();
    }

    public function presentAddressHtml()
    {
        return
            "<p>{$this->public_place} {$this->address}, {$this->number}, {$this->city_name}</p>
             <p>{$this->complement}</p>
             <p>{$this->state_name} - {$this->uf}</p>
             <p>CEP {$this->postal_code}</p>";
    }

    public function presentFullAddress()
    {
        return sprintf('%s %s, %s', $this->public_place, $this->address, $this->number);
    }

    public function presentReceiver()
    {
        if (! empty($this->getReceiver())) {
            return $this->getReceiver();
        }

        if ($this->getObject() instanceof OrderAddress) {
            return $this->getOrder()->getCustomer()->getName();
        }

        if ($this->getObject() instanceof CustomerAddress) {
            return $this->getCustomer()->getName();
        }
    }

}