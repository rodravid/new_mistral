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
        $code = $this->getCriticalAcclaim()->getCode();
        $path = $code;

        if (in_array($code, ['gambero_rosso', 'decanter'])) {

            if ($code == 'decanter' && $this->getValue() > 5) {
                return $this->getScoreValueSeal($path);
            }

            $path .= sprintf('/%s', $this->getValue());

            return sprintf('<img src="%s" />', asset_web(sprintf('images/wine_seals/%s.%s', $path, 'png')));
        }

        return $this->getScoreValueSeal($path);
    }

    protected function getScoreValueSeal($path)
    {
        return sprintf('<img src="%s" /><span>%s</span>', asset_web(sprintf('images/wine_seals/%s.%s', $path, 'png')), $this->getValue());
    }
}