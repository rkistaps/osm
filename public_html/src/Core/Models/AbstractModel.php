<?php

declare(strict_types=1);

namespace OSM\Core\Models;

use OSM\Core\Helpers\StringHelper;

abstract class AbstractModel
{
    public ?int $id;

    public function getPrimaryKey(): array
    {
        return ['id'];
    }

    public function isNew(): bool
    {
        return !isset($this->id) || !$this->id;
    }

    public function __set($name, $value)
    {
        $nameCandidate = StringHelper::toCamelCase($name);
        if (property_exists($this, $nameCandidate)) {
            $this->$nameCandidate = $value;
        }
    }
}
