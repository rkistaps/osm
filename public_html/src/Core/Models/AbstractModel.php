<?php

declare(strict_types=1);

namespace OSM\Core\Models;

use OSM\Core\Helpers\StringHelper;
use OSM\Core\Interfaces\ModelDataHydratorInterface;

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
        $hydrator = getContainer()->get(ModelDataHydratorInterface::class);

        $nameCandidate = StringHelper::toCamelCase($name);
        if (property_exists($this, $nameCandidate)) {
            $hydrator->hydrateProperty($this, $nameCandidate, $value);
        }
    }

    public function __toString()
    {
        $hydrator = getContainer()->get(ModelDataHydratorInterface::class);

        return print_r($hydrator->extract($this), true);
    }
}
