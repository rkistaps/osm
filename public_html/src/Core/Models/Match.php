<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Match extends AbstractModel
{
    public const TYPE_FRIENDLY = 'friendly';

    // national championships
    public const TYPE_CHAMPIONSHIP_LEAGUE = 'championship-league';
    public const TYPE_CHAMPIONSHIP_CUP = 'championship-cup';

    // international championships
    public const TYPE_INT_CUP_QUALIFY = 'int-cup-qualify';
    public const TYPE_CHAMPIONS_LEAGUE = 'champions-league';
    public const TYPE_CHAMPIONS_PLAYOFF = 'champions-playoff';
    public const TYPE_OSM_CUP_LEAGUE = 'osm-cup-league';
    public const TYPE_OSM_CUP_PLAYOFF = 'osm-cup-playoff';
    public const TYPE_CHALLENGERS_CUP_LEAGUE = 'challengers-cup-league';
    public const TYPE_CHALLENGERS_CUP_PLAYOFF = 'challengers-cup-playoff';

    // world cups
    public const TYPE_WORLD_CUP_QUALIFY = 'world-cup-qualify';
    public const TYPE_WORLD_CUP_LEAGUE = 'world-cup-league';
    public const TYPE_WORLD_CUP_PLAYOFF = 'world-cup-playoff';

    const TICKET_PRICE_LEVEL_VERY_LOW = 'very-low';
    const TICKET_PRICE_LEVEL_LOW = 'low';
    const TICKET_PRICE_LEVEL_NORMAL = 'normal';
    const TICKET_PRICE_LEVEL_HIGH = 'high';
    const TICKET_PRICE_LEVEL_VERY_HIGH = 'very-high';

    const TICKET_PRICE_LEVELS = [
        self::TICKET_PRICE_LEVEL_VERY_LOW,
        self::TICKET_PRICE_LEVEL_LOW,
        self::TICKET_PRICE_LEVEL_NORMAL,
        self::TICKET_PRICE_LEVEL_HIGH,
        self::TICKET_PRICE_LEVEL_VERY_HIGH,
    ];

    public int $homeTeamId;
    public int $awayTeamId;

    public ?int $homeTeamLineupId;
    public ?int $awayTeamLineupId;

    public string $seriesType;
    public ?int $seriesId;
    public ?int $seriesRound;

    public int $homeTeamGoals = 0;
    public int $awayTeamGoals = 0;

    public bool $isPlayed = false;
    public bool $isWalkover = false;

    public string $ticketPriceLevel = self::TICKET_PRICE_LEVEL_NORMAL;

    public function isFriendly(): bool
    {
        return $this->seriesType === self::TYPE_FRIENDLY;
    }
}
