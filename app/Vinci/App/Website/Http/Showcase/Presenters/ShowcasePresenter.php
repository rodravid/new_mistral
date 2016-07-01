<?php

namespace Vinci\App\Website\Http\Showcase\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ShowcasePresenter extends AbstractPresenter
{

    public function presentItems()
    {
        return $this->getItems();
    }

    public function presentLink()
    {
        if (! empty($url = $this->getUrl())) {
            return $url;
        }

        return $this->getWebPath();
    }

    public function presentBannerImageUrl()
    {
        if ($this->hasImage('banner')) {
            return $this->getImage('banner')->getWebPath();
        }

        return asset_web('images/bg-pais.jpg');
    }

}