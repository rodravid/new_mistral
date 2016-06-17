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
        if ($this->hasImage('desktop')) {
            return $this->getImage('desktop')->getWebPath();
        }

        return asset_web('images/no_photo.png');
    }

}