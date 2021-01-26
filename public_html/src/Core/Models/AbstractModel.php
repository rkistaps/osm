<?php

declare(strict_types=1);

namespace OSM\Core\Models;

abstract class AbstractModel
{
    public function getPrimaryKey(): array
    {
        return ['id'];
    }

    public function isNew(): bool
    {
        return !$this->id;
    }

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
