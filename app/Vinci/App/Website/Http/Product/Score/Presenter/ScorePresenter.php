<?php

namespace Vinci\App\Website\Http\Product\Score\Presenter;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class ScorePresenter extends AbstractPresenter
{

    public function presentFeaturedText()
    {
        return $this->getCriticalAcclaim()->getTitle() . ' ' . $this->getValue() . ' PTS / ' . $this->getYear();
    }

    public function presentSealImg()
    {
        return asset_web(sprintf('images/wine_seals/%s.%s', $this->getCriticalAcclaim()->getCode(), 'png'));
    }
}