<?php

declare(strict_types=1);

namespace OSM\Frontend\Structures;

use OSM\Core\Helpers\Traits\FromArrayTrait;

class Alert
{
    use FromArrayTrait;

    public const TYPE_SUCCESS = 'success';
    public const TYPE_INFO = 'info';
    public const TYPE_WARNING = 'warning';
    public const TYPE_ERROR = 'error';

    public const TYPES = [
        self::TYPE_SUCCESS,
        self::TYPE_INFO,
        self::TYPE_WARNING,
        self::TYPE_ERROR,
    ];

    public string $type = self::TYPE_INFO;
    public string $message;
}
