<?php

namespace Vinci\App\Cms\Http\ProductType\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ProductTypePresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('picture')) {
            return '<img src="' . $this->getImage('picture') . '" style="width: 50px;" />';
        }

        return '--';
    }

}