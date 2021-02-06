<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class PlayerStats extends AbstractModel
{
    // games
    public const TYPE_CHAMPIONSHIP_GAMES = 'league_games';
    public const TYPE_CUP_GAMES = 'cup_games';
    public const TYPE_INTERNATIONAL_CUP_GAMES = 'international_cup_games';
    public const TYPE_NATIONAL_TEAM_GAMES = 'national_team_games';
    public const TYPE_U18_TEAM_GAMES = 'u18_team_games';

    // goals
    public const TYPE_CHAMPIONSHIP_GOALS = 'league_goals';
    public const TYPE_CUP_GOALS = 'cup_goals';
    public const TYPE_INTERNATIONAL_CUP_GOALS = 'international_cup_goals';
    public const TYPE_NATIONAL_TEAM_GOALS = 'national_team_goals';
    public const TYPE_U18_TEAM_GOALS = 'u18_team_goals';

    public int $playerId;
    public int $teamId;
    public int $season;
    public string $type;
    public int $value = 0;
}
