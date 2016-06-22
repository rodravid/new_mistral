<?php

namespace Vinci\Infrastructure\Promotion;

use Illuminate\Contracts\Redis\Database as Redis;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionRepository;

class RedisPromotionRepository implements DiscountPromotionRepository
{

    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function findOneByProduct(ProductInterface $product)
    {

        

    }
}