<?php

namespace Vinci\Domain\Promotion\Types\Discount\Providers;

use Illuminate\Contracts\Cache\Repository as Cache;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionProvider;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionRepository;

class DefaultDiscountPromotionProvider implements DiscountPromotionProvider
{

    private $repository;

    private $cache;

    public function __construct(DiscountPromotionRepository $repository, Cache $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function findValidPromotionFor(ProductInterface $product)
    {
        if ($product->canBePromoted()) {

            $promotion = $this->cache->rememberForever(DiscountPromotionProvider::CACHE_KEY . $product->getId(),
                function () use ($product) {
                    return $this->repository->findOneByProduct($product);
                });

            if ($promotion && $promotion->isValid()) {
                return $promotion;
            }
        }
    }
}