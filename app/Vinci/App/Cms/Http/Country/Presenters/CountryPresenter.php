<?php

namespace Vinci\App\Cms\Http\Country\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class CountryPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('desktop')) {
            return '<img src="' . $this->getImage('map') . '" style="width: 50px;" />';
        }

        return '--';
    }

}