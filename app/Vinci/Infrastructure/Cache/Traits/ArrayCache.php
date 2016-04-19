<?php

namespace Vinci\Infrastructure\Cache\Traits;

use Closure;

trait ArrayCache
{

    protected $_cache;

    public function cache($key, Closure $callback)
    {
        if (! isset($this->_cache[$key])) {
            $this->_cache[$key] = $callback();
        }

        return $this->_cache[$key];
    }

}