<?php

namespace Vinci\App\Cms\Http\Producer\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ProducerPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('map')) {
            return '<img src="' . $this->getImage('map') . '" style="width: 50px;" />';
        }

        return '--';
    }

}