<?php

namespace Vinci\Domain\Promotion\Events\Listeners;

use Illuminate\Contracts\Redis\Database;
use Vinci\Domain\Promotion\Promotion;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionProvider;

class PromotionListener
{

    private $redis;

    public function __construct(Database $redis)
    {
        $this->redis = $redis;
    }

    public function preFlush(Promotion $promotion)
    {
        $this->clearPromotionCache();
    }

    public function preRemove(Promotion $promotion)
    {
        $this->clearPromotionCache();
    }

    private function clearPromotionCache()
    {
        $keys = $this->redis->command('KEYS', ['laravel:' . DiscountPromotionProvider::CACHE_KEY . '*']);

        $this->redis->pipeline(function($pipe) use ($keys) {
            foreach ($keys as $key) {
                $pipe->del($key);
            }
        });
    }

}