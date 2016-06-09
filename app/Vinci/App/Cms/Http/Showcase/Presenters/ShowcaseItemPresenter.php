<?php

namespace Vinci\App\Cms\Http\Showcase\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShowcaseItemPresenter extends AbstractPresenter
{
    public function presentProduct()
    {
        return $this->getProduct();
    }

    public function presentShowcase()
    {
        return $this->getShowcase();
    }

}