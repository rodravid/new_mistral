<?php

namespace Vinci\Domain\Common;

abstract class Enum
{

    protected static $labels = [];

    protected static $cache = [];

    public static function keys()
    {
        return array_keys(static::values());
    }

    public static function values()
    {
        $class = get_called_class();

        if (!isset(self::$cache[$class])) {
            $reflected = new \ReflectionClass($class);
            self::$cache[$class] = $reflected->getConstants();
        }

        return self::$cache[$class];
    }

    public static function valuesLabed()
    {
        return static::$labels;
    }

}