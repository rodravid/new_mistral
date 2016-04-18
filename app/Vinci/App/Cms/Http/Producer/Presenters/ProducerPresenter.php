<?php

namespace Vinci\App\Cms\Http\Producer\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ProducerPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('logo')) {
            return '<img src="' . $this->getImage('logo') . '" style="width: 50px;" />';
        }

        return '--';
    }

    public function presentRegionName()
    {
        if ($region = $this->getRegion()) {
            return $region->getName();
        }
    }

    public function presentRegionLink()
    {
        if ($region = $this->getRegion()) {
            return '<a href="' . route('cms.regions.edit', $region->getId()) . '">' . $region->getName() . '</a>';
        }
    }

}