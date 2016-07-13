<?php

namespace Vinci\Domain\Common\Traits;

use Illuminate\Support\Str;

trait Attributes
{

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return ! is_null($this->getAttribute($key));
    }

    public function __get($key)
    {
        $getter = 'get' . ucfirst($key);

        if (method_exists($this, $getter)) {
            return call_user_func([$this, $getter]);
        }

        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if (array_has($this->attributes, $key)) {
            return array_get($this->attributes, $key);
        }
    }

    public function setAttribute($key, $value)
    {
        array_set($this->attributes, $key, $value);
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $name => $value) {

            $setter = 'set' . ucfirst(Str::camel($name));

            if (method_exists($this, $setter)) {
                call_user_func([$this, $setter], $value);
            } else {
                $this->setAttribute($name, $value);
            }

        }
    }

    public function toArray()
    {
        return $this->attributes;
    }

}