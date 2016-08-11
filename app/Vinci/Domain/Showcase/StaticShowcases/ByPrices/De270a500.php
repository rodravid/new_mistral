<?php

namespace Vinci\Domain\Showcase\StaticShowcases\ByPrices;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcase;
use Vinci\Domain\Template\Template;

class De270a500 extends StaticShowcase
{

    protected $id = -14;

    protected $title = 'De R$270,00 a R$500,00';

    protected $keywords = ' de 270, a 500';

    protected $slug = 'por-preco-de-270-a-500';

    public $parent_breadcrumb;

    public $banner_image_url = 'url/da/imagem';

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

        if ($product->getSalePrice() > 270 && $product->getSalePrice() <= 500) {
            return true;
        }

        return false;
    }
}