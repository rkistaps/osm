<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class UserMeta extends Meta
{
    public const IS_BOT = 'is-bot';

    public const METAS = [
        self::IS_BOT,
    ];

    public int $userId;
}
