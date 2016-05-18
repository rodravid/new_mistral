<?php

namespace Vinci\Domain\ShoppingCart\Services;

use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;

class ShoppingCartService
{

    protected $cartRepository;

    protected $cartProvider;

    protected $cart;

    protected $productRepository;

    public function __construct(ShoppingCartRepository $cartRepository, ShoppingCartProvider $cartProvider, ProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->cartProvider = $cartProvider;
        $this->productRepository = $productRepository;
        $this->cart = $this->cartProvider->getShoppingCart();
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function add()
    {

        $product = $this->productRepository->find(2);

        $item = new ShoppingCartItem();

        $item
            ->setProduct($product)
            ->setProductVariant($product->getMasterVariant())
            ->setQuantity(5);

        $this->cart->addItem($item);


        $this->cartRepository->save($this->cart);
    }

}