<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Wine\CriticalAcclaim;
use Vinci\Domain\Template\Template;

class WineSpectator extends StaticShowcase
{

    protected $id = -4;

    protected $title = 'Wine Spectator';

    protected $keywords = 'wine, spectator';

    protected $slug = 'vinhos-pontuados-wine-spectator';

    public $parent_breadcrumb;

    public $banner_image_url = 'url/da/imagem';

    public function __construct()
    {
        parent::__construct();

        $this->parent_breadcrumb = new stdClass();
        $this->parent_breadcrumb->url = '/c/vinhos-pontuados';
        $this->parent_breadcrumb->title = 'Vinhos pontuados';
    }

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