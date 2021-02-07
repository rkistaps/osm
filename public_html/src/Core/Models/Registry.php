<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Registry extends AbstractModel
{
    public const FRIENDLY_ROUND = 'friendly-round';

    public const REGISTRY_KEYS = [
        self::FRIENDLY_ROUND,
    ];

    public string $key;
    public string $value;
}
