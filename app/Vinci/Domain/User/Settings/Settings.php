<?php

namespace Vinci\Domain\User\Settings;

use ArrayAccess;
use Vinci\Domain\User\User;

class Settings implements ArrayAccess
{

    private $settings;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->settings = $user->getSettings();
    }

    public function all()
    {
        return $this->settings;
    }

    public function clear()
    {
        $this->settings = [];
    }

    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        $this->save();
        return $this;
    }

    public function has($key)
    {
        return isset($this->settings[$key]);
    }

    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->settings[$key];
        }

        return $default;
    }

    public function del($key)
    {
        unset($this->settings[$key]);
        $this->save();
    }

    protected function save()
    {
        $this->user->setSettings($this->settings);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->del($offset);
    }

    public function __get($key)
    {
        return $this->get($key);
    }
}