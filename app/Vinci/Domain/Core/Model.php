<?php

namespace Vinci\Domain\Core;

abstract class Model
{

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    protected function fill(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            call_user_func([$this, 'set' . ucfirst($name)], $value);
        }
    }

    public static function make(array $attributes = [])
    {
        return new static($attributes);
    }

}