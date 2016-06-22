<?php

namespace Vinci\App\Cms\Http\Promotion\DiscountPromotion\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class DiscountPromotionPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('desktop')) {
            return '<img src="' . $this->getImage('desktop') . '" style="width: 50px;" />';
        }

        return '--';
    }

}