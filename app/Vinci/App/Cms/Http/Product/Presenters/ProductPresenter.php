<?php

namespace Vinci\App\Cms\Http\Product\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ProductPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('desktop')) {
            return '<img src="' . $this->getImage('desktop') . '" style="width: 50px;" />';
        }

        return '--';
    }

    public function presentOnline()
    {
        return $this->toAffirmative($this->isOnline());
    }

    public function presentShouldImportStock()
    {
        return $this->toAffirmative($this->shouldImportStock());
    }

    public function presentShouldImportPrice()
    {
        return $this->toAffirmative($this->shouldImportPrice());
    }

}