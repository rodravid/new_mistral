<?php

namespace Vinci\Domain\Product\Services;

use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Product\Events\ProductAddedToFavoritesEvent;
use Vinci\Domain\Product\Events\ProductRemovedFromFavoritesEvent;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;

class FavoriteService
{

    private $productRepository;

    private $customerRepository;

    private $eventDispatcher;

    public function __construct(
        ProductRepository $productRepository,
        CustomerRepository $customerRepository,
        Dispatcher $eventDispatcher
    ) {
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function toggle(ProductInterface $product, CustomerInterface $customer, $toggle = true)
    {
        if ($toggle) {
            return $this->addFavorite($product, $customer);
        }

        return $this->removeFavorite($product, $customer);
    }

    public function addFavorite(ProductInterface $product, CustomerInterface $customer)
    {
        $customer->addProductToFavorites($product);

        $this->customerRepository->save($customer);

        $this->eventDispatcher->fire(new ProductAddedToFavoritesEvent($product, $customer));

        return true;
    }

    public function removeFavorite(ProductInterface $product, CustomerInterface $customer)
    {
        $customer->removeProductFromFavorites($product);

        $this->eventDispatcher->fire(new ProductRemovedFromFavoritesEvent($product, $customer));

        return $this->customerRepository->save($customer);
    }

}