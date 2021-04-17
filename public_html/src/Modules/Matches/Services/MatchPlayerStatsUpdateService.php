<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use Exception;
use OSM\Core\Collections\PlayerStatsCollection;
use OSM\Core\Models\Match;
use OSM\Core\Models\PlayerStats;
use OSM\Core\Repositories\PlayerStatsRepository;
use OSM\Core\Structures\OSMState;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\Player;

class MatchPlayerStatsUpdateService
{
    public const MAPPING = [
        Match::TYPE_CHAMPIONSHIP_LEAGUE => [
            'games' => PlayerStats::TYPE_CHAMPIONSHIP_GAMES,
            'goals' => PlayerStats::TYPE_CHAMPIONSHIP_GOALS,
        ],
    ];

    private PlayerStatsRepository $statsRepository;
    private OSMState $state;

    public function __construct(
        PlayerStatsRepository $statsRepository,
        OSMState $state
    ) {
        $this->statsRepository = $statsRepository;
        $this->state = $state;
    }

    public function processLineup(Lineup $lineup, string $seriesType)
    {
        $playerIds = collect($lineup->players)
            ->map(fn(Player $player) => $player->id)
            ->all();

        $statsTypes = self::MAPPING[$seriesType] ?? null;

        if (!$statsTypes) {
            throw new Exception('Unsupported match type');
        }

        $stats = $this->statsRepository->findAll([
            'player_id' => $playerIds,
            'team_id' => $lineup->teamId,
            'type' => $statsTypes,
            'season' => $this->state->getSeason(),
        ]);

        foreach ($lineup->players as $player) {
            // games
            $this->processStatsType($statsTypes['games'], $player, $stats, $lineup, 1);

            // goals
            if ($player->statistics->goals) {
                $this->processStatsType($statsTypes['goals'], $player, $stats, $lineup, $player->statistics->goals);
            }
        }
    }

    protected function processStatsType(
        string $type,
        Player $player,
        PlayerStatsCollection $stats,
        Lineup $lineup,
        int $value
    ) {
        $playerStats = $stats->getByTypeAndPlayerId($type, $player->id);
        if (!$playerStats) {
            $playerStats = new PlayerStats();
            $playerStats->playerId = $player->id;
            $playerStats->type = $type;
            $playerStats->teamId = $lineup->teamId;
            $playerStats->season = $this->state->getSeason();
        }

        $playerStats->value += $value;

        $this->statsRepository->saveModel($playerStats);
    }
}
