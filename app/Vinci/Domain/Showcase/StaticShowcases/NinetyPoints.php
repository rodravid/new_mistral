<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Template\Template;

class NinetyPoints extends StaticShowcase
{

    protected $id = -5;

    protected $title = '90+ pontos';

    protected $keywords = '90, pontos, pontuados';

    protected $slug = 'vinhos-pontuados-90-mais-pontos';

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
            if ($score->getValue() >= 90) {
                return true;
            }
        }

        return false;
    }
}