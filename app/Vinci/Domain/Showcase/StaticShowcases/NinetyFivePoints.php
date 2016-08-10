<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Template\Template;

class NinetyFivePoints extends StaticShowcase
{

    protected $id = -6;

    protected $title = '95+ pontos';

    protected $keywords = '95, pontos, pontuados';

    protected $slug = '95-mais-pontos';

    public $parent_breadcrumb;

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

        foreach ($product->getHighlightedScores() as $score) {
            if ($score->getValue() >= 95) {
                return true;
            }
        }

        return false;
    }
}