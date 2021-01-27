<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class MatchStats
 * @package OSM\Modules\MatchEngine\Structures
 */
class MatchStats
{
    public int $homeTeamGoals = 0;
    public int $awayTeamGoals = 0;
    public int $homeTeamAttackCount = 0;
    public int $homeTeamShootCount = 0;
    public int $awayTeamAttackCount = 0;
    public int $awayTeamShootCount = 0;
    public Possession $possession;
}
