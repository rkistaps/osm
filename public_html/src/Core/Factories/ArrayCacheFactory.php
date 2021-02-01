<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use OSM\Core\Components\ArrayCache;

class ArrayCacheFactory
{
    /**
     * @var ArrayCache[]
     */
    private array $caches = [];

    public function getForClass(string $classname): ArrayCache
    {
        $cache = $this->caches[$classname] ?? new ArrayCache();

        $this->caches[$classname] = $cache;

        return $cache;
    }
}
