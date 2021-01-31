<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Option extends AbstractModel
{
    public const GROUP_STARTING = 'starting';

    public string $name;
    public string $value;
}
