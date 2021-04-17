<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class ChampionshipTable extends AbstractModel
{
    public int $teamId;
    public int $championshipLeagueId;
    public int $wins = 0;
    public int $draws = 0;
    public int $losses = 0;
    public int $goalsForward = 0;
    public int $goalsAgainst = 0;
    public int $points = 0;
    public int $place = 0;
}
