<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class Injury
 * @package OSM\Modules\MatchEngine\Structures
 */
class Injury
{
    const SEVERITY_LOW = 'low';
    const SEVERITY_MINIMAL = 'minimal';
    const SEVERITY_AVERAGE = 'average';
    const SEVERITY_HIGH = 'high';

    /** @var string */
    public $severity = self::SEVERITY_LOW;

    /** @var int */
    public $minute;
}
