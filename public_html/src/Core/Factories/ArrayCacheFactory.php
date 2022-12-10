<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use OSM\Core\Components\ArrayCache;

class ArrayCacheFactory
{
    /**
     * @var ArrayCache[]
     */
    private static array $caches = [];

    public static function getForClass(string $classname): ArrayCache
    {
        $cache = self::$caches[$classname] ?? new ArrayCache();

        self::$caches[$classname] = $cache;

        return $cache;
    }
}
