<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class Injury
 * @package OSM\Modules\MatchEngine\Structures
 */
class Injury
{
    const SEVERITY_LOW = 'low';
    const SEVERITY_MINOR = 'minor';
    const SEVERITY_AVERAGE = 'average';
    const SEVERITY_HIGH = 'high';

    public string $severity = self::SEVERITY_LOW;
    public int $minute;
}
