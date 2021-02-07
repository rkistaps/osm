<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Registry;

/**
 * @method Registry firstWhere($key, $operator = null, $value = null)
 */
class RegistryCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Registry::class;
    }
}
