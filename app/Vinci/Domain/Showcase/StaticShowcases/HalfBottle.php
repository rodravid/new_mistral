<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Template\Template;

class HalfBottle extends StaticShowcase
{

    protected $id = '-1';

    protected $title = 'Meias garrafas';

    protected $keywords = '375 ml, 187 ml, meia, meias, meias garrafas, meia garrafa';

    protected $slug = 'meias-garrafas';

    public $banner_image_url;

    public function __construct()
    {
        parent::__construct();
        
        $this->banner_image_url = asset_web('images/bg-meia-garrafa.jpg');
    }
    
    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 12);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {
        return $product->isWine() && $product->isHalfBottle();
    }
}