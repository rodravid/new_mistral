<?php

namespace Vinci\Domain\Showcase\StaticShowcases\ByPrices;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcase;
use Vinci\Domain\Template\Template;

class Ate60 extends StaticShowcase
{

    protected $id = -10;

    protected $title = 'Até R$60,00';

    protected $keywords = '60, 60 reais, ate 60';

    protected $slug = 'por-preco-ate-60';

    public $parent_breadcrumb;

    public $banner_image_url;

    public function __construct()
    {
        parent::__construct();

        $this-> banner_image_url = asset_web('images/bg-por-preco.jpg');
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

        if ($product->getSalePrice() <= 60) {
            return true;
        }

        return false;
    }
}