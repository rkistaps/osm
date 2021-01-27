<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class Penalty
 * @package OSM\Modules\MatchEngine\Structures
 */
class Penalty
{
    const TYPE_YELLOW_CARD = 'yellow-card';
    const TYPE_RED_CARD = 'red-card';

    public string $type;
    public int $minute;
}
