<?php

namespace Vinci\Domain\ShoppingCart\Services;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\Product\Repositories\ProductVariantRepository;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider;
use Vinci\Domain\ShoppingCart\Repositories\ShoppingCartRepository;
use Vinci\Domain\ShoppingCart\Resolver\Contracts\ItemResolver;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartService
{

    protected $entityManager;

    protected $cartProvider;

    protected $cartRepository;

    protected $variantRepository;

    protected $itemResolver;

    protected $event;

    protected $cart;

    public function __construct(
        EntityManagerInterface $entityManager,
        ShoppingCartProvider $cartProvider,
        ShoppingCartRepository $cartRepository,
        ProductVariantRepository $variantRepository,
        ItemResolver $itemResolver,
        Dispatcher $event
    ) {
        $this->entityManager = $entityManager;
        $this->cartProvider = $cartProvider;
        $this->cartRepository = $cartRepository;
        $this->variantRepository = $variantRepository;
        $this->itemResolver = $itemResolver;
        $this->event = $event;

        $this->boot();
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(ShoppingCartInterface $cart)
    {
        $this->cart = $cart;
    }

    protected function boot()
    {
        try {

            $this->initCart();

            $this->checkExpiration();

        } catch (Exception $e) {

        }
    }

    protected function initCart()
    {
        $this->cart = $this->cartProvider->getShoppingCart();
    }

    protected function checkExpiration()
    {
        //
    }

    public function addItem($productVariant, $quantity = 1)
    {
        $this->entityManager->transactional(function($em) use ($productVariant, $quantity) {

            $productVariant = $this->getProductVariant($productVariant);

            $item = $this->itemResolver->resolve($this->cart, $productVariant, compact('quantity'));

            if ($this->cart->hasItem($item)) {
                $item->incrementQuantity($quantity);
            } else {
                $this->cart->addItem($item);
            }

            $this->dispatchEvents($this->cart);

            $em->persist($this->cart);
            $em->persist($productVariant);

            $em->lock($productVariant, LockMode::OPTIMISTIC, $productVariant->getVersion());
        });
    }


    public function syncQuantity($item, $quantity)
    {
        $this->entityManager->transactional(function($em) use ($item, $quantity) {

            $productVariant = $this->getItem($item)->getProductVariant();

            $item = $this->itemResolver->resolve($this->cart, $productVariant, compact('quantity'));

            $item->syncQuantity($quantity);

            $this->saveCart();

            $em->persist($productVariant);

            $em->lock($productVariant, LockMode::OPTIMISTIC, $productVariant->getVersion());
        });

    }

    protected function saveCart()
    {
        $this->dispatchEvents($this->cart);
        $this->entityManager->persist($this->cart);
    }

    public function dispatchEvents(ShoppingCartInterface $cart)
    {
        foreach ($cart->releaseEvents() as $event) {
            $this->event->fire($event);
        }
    }

    protected function getProductVariant($variant)
    {
        if (! $variant instanceof ProductVariantInterface) {
            return $this->variantRepository->getOneValidById($variant);
        }

        return $variant;
    }

    public function removeItem($item)
    {
        $this->entityManager->transactional(function() use ($item) {

            $item = $this->getItem($item);

            $this->cart->removeItem($item);

            $this->saveCart();
        });
    }

    protected function getItem($item)
    {
        if (! $item instanceof ShoppingCartItem) {
            return $this->cart->findItemById($item);
        }

        return $item;
    }

    public function __call($name, array $arguments)
    {
        return call_user_func_array([$this->cart, $name], $arguments);
    }

}