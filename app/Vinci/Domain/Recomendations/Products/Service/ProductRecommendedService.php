<?php
namespace Vinci\Domain\Recomendations\Products\Service;

use Vinci\Domain\Product\Product;
use Vinci\Domain\ShoppingCart\ShoppingCart;

interface ProductRecommendedService
{
    public function getRecommendedForShoppingCartPage(ShoppingCart $currentCart, $quantity = 4);

    public function getRecommendedByShoppingCart(ShoppingCart $currentCart);

    public function getRecommendedByProduct(Product $product);

    public function getRecommendedProducts();

}