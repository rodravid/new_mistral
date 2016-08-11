<?php

namespace Vinci\Domain\Showcase\StaticShowcases\ByPrices;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcase;
use Vinci\Domain\Template\Template;

class De100a170 extends StaticShowcase
{

    protected $id = -12;

    protected $title = 'De R$100,00 a R$170,00';

    protected $keywords = 'de 100, a 170';

    protected $slug = 'por-preco-de-100-a-170';

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
        return app('em')->getReference(Template::class, 7);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {

        if ($product->getSalePrice() > 100 && $product->getSalePrice() <= 170) {
            return true;
        }

        return false;
    }
}