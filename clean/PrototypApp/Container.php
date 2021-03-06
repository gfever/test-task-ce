<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp;

/**
 * Class Container
 * @package PrototypApp
 */
class Container
{
    private static $instances = [];

    private function __construct()
    {
    }

    /**
     * @param string $className
     * @return mixed
     */
    public static function make(string $className)
    {
        return self::$instances[$className] ?? new $className;
    }

    /**
     * @param string $className
     * @param $instance
     */
    public static function instance(string $className, $instance): void
    {
        self::$instances[$className] = $instance;
    }

    /**
     * @param string $className
     * @return bool
     */
    public static function isInstanced(string $className): bool
    {
        return isset(self::$instances[$className]);
    }
}