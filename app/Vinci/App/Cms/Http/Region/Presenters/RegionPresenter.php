<?php

namespace Vinci\App\Cms\Http\Region\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class RegionPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('map')) {
            return '<img src="' . $this->getImage('map') . '" style="width: 50px;" />';
        }

        return '--';
    }

    public function presentCountryName()
    {
        if ($country = $this->getCountry()) {
            return $country->getName();
        }
    }

    public function presentCountryLink()
    {
        if ($country = $this->getCountry()) {
            return '<a href="' . route('cms.countries.edit', $country->getId()) . '">' . $country->getName() . '</a>';
        }
    }

}