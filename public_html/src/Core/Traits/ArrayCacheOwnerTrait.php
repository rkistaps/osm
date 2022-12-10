<?php

declare(strict_types=1);

namespace OSM\Core\Traits;

use OSM\Core\Components\ArrayCache;
use OSM\Core\Factories\ArrayCacheFactory;

trait ArrayCacheOwnerTrait
{
    public function getArrayCache(): ArrayCache
    {
        return ArrayCacheFactory::getForClass(get_called_class());
    }
}