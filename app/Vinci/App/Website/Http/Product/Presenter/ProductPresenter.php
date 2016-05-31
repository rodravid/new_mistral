<?php

namespace Vinci\App\Website\Http\Product\Presenter;

use Vinci\Domain\Product\Presenter\ProductPresenter as BaseProductPresenter;

class ProductPresenter extends BaseProductPresenter
{

    public function presentShortDescription()
    {
        return substr($this->getDescription(), 0, 80);
    }
}