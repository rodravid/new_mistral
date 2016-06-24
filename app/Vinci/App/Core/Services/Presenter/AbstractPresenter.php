<?php

namespace Vinci\App\Core\Services\Presenter;

use Carbon\Carbon;
use Robbo\Presenter\Presenter as BasePresenter;
use Vinci\App\Core\Utils\Mask;
use Vinci\Domain\Common\Gender;

abstract class AbstractPresenter extends BasePresenter
{

    protected function toAffirmative($expression)
    {
        return $expression ? 'Sim' : 'Não';
    }

    protected function toDefaultDateTime($date)
    {
        if (! empty($date) && $date instanceof Carbon) {
            return  $date->format('d/m/Y \à\s H:i\h');
        }
    }

    protected function toDefaultDate($date)
    {
        if (! empty($date) && $date instanceof Carbon) {
            return  $date->format('d/m/Y');
        }
    }

    protected function toMaskedPhoneNumber($phone)
    {
        return mask($phone, Mask::PHONE);
    }

    protected function toReal($amount)
    {
        return number_format($amount, 2, ',', '.');
    }

    protected function toRealCurrency($amount)
    {
        return 'R$ ' . $this->toReal($amount);
    }

    public function presentAmount()
    {
        return $this->toRealCurrency($this->getAmount());
    }

    public function presentCreatedAt()
    {
        return $this->toDefaultDateTime($this->getCreatedAt());
    }

    public function presentUpdatedAt()
    {
        return $this->toDefaultDateTime($this->getUpdatedAt());
    }

    public function presentStartsAt()
    {
        return $this->toDefaultDateTime($this->getStartsAt());
    }

    public function presentExpirationAt()
    {
        $date = $this->toDefaultDateTime($this->getExpirationAt());

        if (! $date) {
            return 'Nunca expira';
        }

        return $date;
    }

    public function presentBirthday()
    {
        return $this->toDefaultDate($this->getBirthday());
    }

    public function presentStatus()
    {
        switch ($this->getStatus()) {
            case 0:
                return 'Rascunho';
            break;
            case 1:
                return 'Publicado';
            break;
        }
    }

    public function presentStatusHtml()
    {
        return present_status_html($this->getStatus());
    }

    public function presentUserName()
    {
        if ($user = $this->getUser()) {
            return $user->getName();
        }
    }

    public function presentVisibleSite()
    {
        return $this->toAffirmative($this->getVisibleSite());
    }

    public function presentMemberSinceDate()
    {
        return $this->getCreatedAt()->formatLocalized("%b/%Y");
    }

    public function presentPhone()
    {
        return $this->toMaskedPhoneNumber($this->getPhone());
    }

    public function presentCellPhone()
    {
        return $this->toMaskedPhoneNumber($this->getCellPhone());
    }

    public function presentCommercialPhone()
    {
        return $this->toMaskedPhoneNumber($this->getCommercialPhone());
    }

    public function presentGender()
    {
        switch($this->getGender()) {
            case Gender::MALE:
                return 'Masculino';
            break;
            case Gender::FEMALE:
                return 'Feminino';
                break;
        }
    }

    public function presentQuantityUnits()
    {
        $quantity = $this->getQuantity();

        if ($quantity == 1) {
            return '1 unidade';
        }

        return sprintf('%s unidades', $quantity);
    }

    public function presentTotal()
    {
        return $this->toRealCurrency($this->getTotal());
    }

    public function presentPrice()
    {
        return $this->toRealCurrency($this->getPrice());
    }

    public function presentWebPath()
    {
        return $this->getWebPath();
    }

    public function presentTemplateCss()
    {
        if ($this->hasTemplate()) {
            return $this->getTemplate()->getCode();
        }

        return 'template1';
    }

}