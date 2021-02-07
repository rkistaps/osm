<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Meta extends AbstractModel
{
    public const META_TYPE_USER = 'user';

    public string $key;
    public string $value;
}
