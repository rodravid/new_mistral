<?php
namespace Vinci\Domain\GoogleShopping;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;
use LukeSnowden\GoogleShoppingFeed\Containers\GoogleShopping;
use Vinci\Domain\Product\Repositories\ProductRepository;

class GoogleShoppingService
{
    private $productRepository;
    private $cache;

    public function __construct(ProductRepository $productRepository, Repository $cache)
    {
        $this->productRepository = $productRepository;
        $this->cache = $cache;
    }

    public function getProductsCollection()
    {
        $products = $this
            ->productRepository
            ->getAvailableProductsNotInTypes([3, 9]);
        return Collection::make($products);
    }

    public function generateGoogleShoppingXML()
    {
        return $this->cache->remember('googleShoppingXML', 60, function () {
            $this->generateHeaderOfXML();
            $products = $this->getProductsCollection();
            $this->buildBodyOfXML($products);
            return $this->getXML();
        });
    }

    public function generateHeaderOfXML()
    {
        $title = "VINCI - Locuos por vinho!";
        GoogleShopping::title($title);

        $link = "https://www.vinci.com.br/";
        GoogleShopping::link($link);

        $description = "A Vinci é uma das melhores e mais premiadas importadoras de vinhos do país. 
                        Em poucos lugares do mundo você encontra uma seleção de vinhos e produtores
                        tão conceituados e premiados como no catálogo da Vinci.";
        GoogleShopping::description($description);
    }

    public function buildBodyOfXML($products)
    {
        foreach ($products as $product) {
            if ($product->isOnline()) {
                $item = GoogleShopping::createItem();
                $item->id($product->getId());
                $item->title($product->getTitle());
                $item->description($product->getDescription());
                $item->price($product->getSalePrice());
                $item->mpn($product->getId());
                $item->sale_price($product->getSalePrice());
                $item->link($product->present()->full_web_path);
                $item->image_link($product->present()->image_url);
                $item->product_type('Bebidas');
                $item->google_product_category('499676');
                $item->condition('new');
                $item->availability('in stock');
                $item->brand('Vinci');
            }
        }
    }

    public function getXML()
    {
        return GoogleShopping::asRss(false);
    }
}