<?php

namespace Vinci\Domain\Product\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ProductPresenter extends AbstractPresenter
{

    public function presentSalePrice()
    {
        return $this->toRealCurrency($this->getSalePrice());
    }

    public function presentOriginalSalePrice()
    {
        return $this->toRealCurrency($this->getOriginalSalePrice());
    }

    public function presentWebPath()
    {
        return $this->getWebPath();
    }

    public function presentImageUrl()
    {
        if ($this->hasImage('photo')) {
            return $this->getImage('photo')->getWebPath();
        }

        return asset_web('images/no_photo.png');
    }

    public function presentCardImageUrl()
    {
        if ($this->hasImage('photo')) {

            $small = $this->getImage('photo')->getVersion('small');

            if (! empty($small)) {
                return $small->getWebPath();
            }

            return $this->getImage('photo')->getWebPath();
        }

        return asset_web('images/no_photo.png');
    }

}