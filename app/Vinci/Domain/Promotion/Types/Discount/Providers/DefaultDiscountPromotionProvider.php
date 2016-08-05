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

            if (($promotion = $product->getCurrentPromotion()) !== null) {
                return $promotion;
            }

            $promotion = $this->cache->rememberForever(DiscountPromotionProvider::CACHE_KEY . $product->getId(), function () use ($product) {
                $promo = $this->repository->findOneByProduct($product);

                return $promo ? $promo : false;
            });

            if ($promotion && $promotion->isValid()) {
                $product->setCurrentPromotion($promotion);
                return $promotion;
            }
        }
    }
}