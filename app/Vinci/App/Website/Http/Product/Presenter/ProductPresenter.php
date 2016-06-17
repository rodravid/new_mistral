<?php

namespace Vinci\App\Website\Http\Product\Presenter;

use Vinci\Domain\Product\Presenter\ProductPresenter as BaseProductPresenter;

class ProductPresenter extends BaseProductPresenter
{

    public function presentCardTitle()
    {
        return $this->getTitle();
    }

    public function presentImageUrl()
    {
        if ($this->hasImage('desktop')) {
            return $this->getImage('desktop')->getWebPath();
        }

        return asset_web('images/no_photo.png');
    }

    public function presentShortnedDescription()
    {
        return substr($this->getDescription(), 0, 80);
    }

    public function presentShortDescription()
    {
        return $this->getShortDescription();
    }

    public function presentOriginalSalePriceHtml()
    {
        if ($price = $this->getOriginalSalePrice()) {
            return sprintf('<p class="old-price">De <span>%s</span></p>', $this->original_sale_price);
        }
    }

    public function presentTemplateCss()
    {
        if ($this->hasTemplate()) {
            return $this->getTemplate()->getCode();
        }

        return 'template1';
    }

}