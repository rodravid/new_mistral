<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Template\Template;

class ScoredWines extends StaticShowcase
{

    protected $id = -2;

    protected $title = 'Vinhos pontuados';

    protected $keywords = 'pontuados, vinhos pontuados, pontuado';

    protected $slug = 'vinhos-pontuados';

    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 9);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {
        return $product->isWine() && $product->hasScores();
    }
}