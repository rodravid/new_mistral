<?php

namespace Vinci\App\Website\Http\Product\Presenter;

use Vinci\Domain\Product\Presenter\ProductPresenter as BaseProductPresenter;
use Vinci\Domain\Promotion\PromotionSealProvider;

class ProductPresenter extends BaseProductPresenter
{

    public function presentCardTitle()
    {
        return $this->limitTo($this->getTitle(), 47);
    }

    public function presentShortnedDescription()
    {
        return $this->limitTo($this->getDescription(), 80);
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

    public function getPromotionSeal()
    {
        return app(PromotionSealProvider::class)->provideFor($this->getObject());
    }

}