<?php

namespace Vinci\Domain\ERP\Transformer;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{

    public function normalizeString($string)
    {
        return Str::upper(Str::ascii(trim($string)));
    }

}