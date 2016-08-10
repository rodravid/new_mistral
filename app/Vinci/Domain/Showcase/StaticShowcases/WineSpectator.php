<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Wine\CriticalAcclaim;
use Vinci\Domain\Template\Template;

class WineSpectator extends StaticShowcase
{

    protected $id = -4;

    protected $title = 'Wine Spectator';

    protected $keywords = 'wine, spectator';

    protected $slug = 'wine-spectator';

    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 9);
    }

    public function isSatisfiedBy(ProductInterface $product)
    {
        if (! $product->isWine()) {
            return false;
        }

        foreach ($product->getScores() as $score) {
            if ($score->getCriticalAcclaim()->getCode() == CriticalAcclaim::WINE_SPECTATOR) {
                return true;
            }
        }

        return false;
    }
}