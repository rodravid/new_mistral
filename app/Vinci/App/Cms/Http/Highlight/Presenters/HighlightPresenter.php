<?php

namespace Vinci\App\Cms\Http\Highlight\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class HighlightPresenter extends AbstractPresenter
{

    public function presentImageHtml()
    {
        if ($this->hasImage('desktop')) {
            return '<img src="' . $this->getImage('desktop') . '" style="width: 50px;" />';
        }

        return '--';
    }

}