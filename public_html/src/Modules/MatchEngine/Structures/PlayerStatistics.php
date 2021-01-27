<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class PlayerStatistics
 * @package OSM\Modules\MatchEngine\Structures
 */
class PlayerStatistics
{
    public int $goals = 0;
    public int $yellowCards = 0;
    public bool $hasRedCard = false;
    public int $shotsOnGoal = 0;
    public int $assists = 0;
    public int $tackles = 0;
}
