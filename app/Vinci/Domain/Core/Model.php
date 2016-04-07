<?php

namespace Vinci\Domain\Core;

abstract class Model
{

    public function fill(array $attributes)
    {
        foreach ($attributes as $name => $value) {

            $setter = 'set' . ucfirst($name);

            if (method_exists($this, $setter)) {
                call_user_func([$this, $setter], $value);
            }

        }
    }

    public static function make(array $attributes = [])
    {
        $model = new static;

        $model->fill($attributes);

        return $model;
    }

    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter)) {
            return call_user_func([$this, $getter]);
        }

        throw new \RuntimeException("No getter found for {$name}");
    }

    public function getFormValue($name)
    {
        return $this->$name;
    }

}