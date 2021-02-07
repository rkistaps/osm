<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Registry extends AbstractModel
{
    public const FRIENDLY_ROUND = 'friendly-round';
    public const BOT_COUNTER = 'bot-counter';

    public const REGISTRY_KEYS = [
        self::FRIENDLY_ROUND,
        self::BOT_COUNTER,
    ];

    public string $key;
    public string $value;
}
