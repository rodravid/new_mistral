<?php

namespace Vinci\Domain\Showcase\StaticShowcases\ByPrices;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcase;
use Vinci\Domain\Template\Template;

class De170a270 extends StaticShowcase
{

    protected $id = -13;

    protected $title = 'De R$170,00 a R$270,00';

    protected $keywords = 'de 170, a 270';

    protected $slug = 'por-preco-de-170-a-270';

    public $parent_breadcrumb;

    public function __construct()
    {
        parent::__construct();

        $this->parent_breadcrumb = new stdClass();
        $this->parent_breadcrumb->url = '#';
        $this->parent_breadcrumb->title = 'Por Preços';
    }

    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 9);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {

        if ($product->getSalePrice() > 170 && $product->getSalePrice() <= 270) {
            return true;
        }

        return false;
    }
}