<?php

declare(strict_types=1);

namespace OSM\Modules\MatchEngine\Interfaces;

use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\MatchResult;
use OSM\Modules\MatchEngine\Structures\MatchSettings;

interface MatchEngineInterface
{
    public function playMatch(Lineup $homeTeam, Lineup $awayTeam, MatchSettings $matchSettings): MatchResult;
}
