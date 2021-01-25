<?php

declare(strict_types=1);

namespace OSM\Core\Models;

abstract class AbstractModel
{
    /**
     * Hydrate model with data
     * @param array $data
     */
    public function hydrate(array $data)
    {
    }

    /**
     * Expose model data
     * @return array
     */
    public function expose(): array
    {
    }
}
