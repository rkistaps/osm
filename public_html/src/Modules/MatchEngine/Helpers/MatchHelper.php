<?php

namespace OSM\Modules\MatchEngine\Helpers;

/**
 * Class MatchHelper
 * @package OSM\Modules\MatchEngine\helpers
 */
class MatchHelper
{
    const MATCH_LENGTH = 93;

    /**
     * Get random match minute
     * @return int
     */
    public static function getRandomMinute(): int
    {
        return rand(1, self::MATCH_LENGTH);
    }
}
