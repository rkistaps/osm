<?php

declare(strict_types=1);

namespace OSM\Core\Translations\Structures;

class Domains
{
    public const DOMAIN_DEFAULT = 'default';
    public const DOMAIN_BACKEND = 'backend';
    public const DOMAIN_FRONTEND = 'front';

    public const DOMAINS = [
        self::DOMAIN_DEFAULT,
        self::DOMAIN_FRONTEND,
        self::DOMAIN_BACKEND,
    ];
}
