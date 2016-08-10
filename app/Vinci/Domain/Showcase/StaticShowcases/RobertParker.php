<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Wine\CriticalAcclaim;
use Vinci\Domain\Template\Template;

class RobertParker extends StaticShowcase
{

    protected $id = -3;

    protected $title = 'Robert Parker';

    protected $keywords = 'robert, parker';

    protected $slug = 'robert-parker';

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
        
        foreach ($product->getScores() as $score) {
            if ($score->getCriticalAcclaim()->getCode() == CriticalAcclaim::ROBERT_PARKER) {
                return true;
            }
        }

        return false;
    }
}