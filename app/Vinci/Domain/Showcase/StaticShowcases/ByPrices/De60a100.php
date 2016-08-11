<?php

namespace Vinci\Domain\Showcase\StaticShowcases\ByPrices;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcase;
use Vinci\Domain\Template\Template;

class De60a100 extends StaticShowcase
{

    protected $id = -11;

    protected $title = 'De R$60,00 a R$100,00';

    protected $keywords = ' de 60, a 100';

    protected $slug = 'por-preco-de-60-a-100';

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

        if ($product->getSalePrice() > 60 && $product->getSalePrice() <= 100) {
            return true;
        }

        return false;
    }
}