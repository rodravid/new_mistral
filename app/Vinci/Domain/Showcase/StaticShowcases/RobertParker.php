<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Wine\CriticalAcclaim;
use Vinci\Domain\Template\Template;

class RobertParker extends StaticShowcase
{

    protected $id = -3;

    protected $title = 'Robert Parker';

    protected $keywords = 'robert, parker';

    protected $slug = 'robert-parker';

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
            if ($score->getCriticalAcclaim()->getCode() == CriticalAcclaim::ROBERT_PARKER) {
                return true;
            }
        }

        return false;
    }
}