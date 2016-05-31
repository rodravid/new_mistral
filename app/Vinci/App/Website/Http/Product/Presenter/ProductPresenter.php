<?php

namespace Vinci\App\Website\Http\Product\Presenter;

use Vinci\Domain\Product\Presenter\ProductPresenter as BaseProductPresenter;

class ProductPresenter extends BaseProductPresenter
{

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
            return sprintf('<p class="old-price">De <span>%s</span></p>', $this->sale_price);
        }
    }

}