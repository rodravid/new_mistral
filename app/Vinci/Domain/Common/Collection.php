<?php

namespace Vinci\Domain\Common;

use Illuminate\Support\Collection as IlluminateCollection;

class Collection extends IlluminateCollection
{

    public function getCacheKey()
    {
        return md5($this);
    }

}