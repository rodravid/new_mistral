<?php

namespace Vinci\App\Cms\Http\Promotion\DiscountPromotion\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class PromotionItemPresenter extends AbstractPresenter
{
    public function presentProduct()
    {
        return $this->getProduct();
    }

    public function presentPromotion()
    {
        return $this->getPromotion();
    }

}