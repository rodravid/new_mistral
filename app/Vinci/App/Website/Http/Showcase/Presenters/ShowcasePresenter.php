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
        if (isset($this->object->banner_image_url)) {
            return $this->object->banner_image_url;
        }

        if ($this->hasImage('banner')) {
            return $this->getImage('banner')->getWebPath();
        }

        return '';
    }

}