<?php

namespace Vinci\Domain\Core;

use ArrayAccess;
use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class Model implements ArrayAccess
{

    public function fill(array $attributes)
    {
        foreach ($attributes as $name => $value) {

            $setter = 'set' . ucfirst(Str::camel($name));

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

        return $this->$name;
    }

    public function getFormValue($name)
    {
        return $this->$name;
    }

    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    public function hasProperty($name)
    {
        return property_exists($this, $name);
    }

    public function setDateFromFormat($field, $date, $format)
    {
        if (empty($date)) {
            $this->{$field} = null;
            return $this;
        }

        if (! $date instanceof Carbon) {
            $this->{$field} = Carbon::createFromFormat($format, $date);
            return $this;
        }
    }

}