<?php

namespace Vinci\Domain\Recomendations\Products\Service;


use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ShoppingCart\ShoppingCart;

class DefaultProductRecommendedService implements ProductRecommendedService
{

    private $productRepository;

    private $presenter;

    public function __construct(
        ProductRepository $productRepository,
        Presenter $presenter
    ) {

        $this->productRepository = $productRepository;
        $this->presenter = $presenter;
    }

    public function getRecommendedForShoppingCartPage(ShoppingCart $currentCart, $quantity = 4)
    {
        if ($currentCart->isEmpty()) {
            return $this->getRecommendedProducts();
        }

        return $this->getRecommendedByShoppingCart($currentCart);
    }

    public function getRecommendedByShoppingCart(ShoppingCart $currentCart, $quantity = 4)
    {
        $randomProduct = $currentCart->getRandomItem()->getProduct();

        return $this->getRecommendedByProduct($randomProduct);
    }

    public function getRecommendedByProduct(Product $product, $quantity = 4, $randomize = true)
    {
        $products = $this->productRepository->getProductsByCountryAndType($product->getCountry(), $product->getProductType(), $quantity, [$product->getId()], $randomize);

        if ($products->isEmpty()) {
            return $this->getRecommendedProducts();
        }

        return $this->presenter->paginator($products, ProductPresenter::class);
    }

    public function getRecommendedProducts()
    {
        $products = $this->productRepository->getRandomProducts();
        
        return $this->presenter->paginator($products, ProductPresenter::class);
    }
}