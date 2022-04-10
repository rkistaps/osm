<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup;

use OSM\Core\Collections\TeamLineupPlayerCollection;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Modules\Lineup\Exceptions\LineupValidationException;
use OSM\Modules\MatchEngine\Services\LineupValidatorService;

class LineupSavingService
{
    private PlayerRepository $playerRepository;
    private TeamLineupRepository $lineupRepository;
    private TeamLineupPlayerRepository $lineupPlayerRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        TeamLineupRepository $lineupRepository,
        TeamLineupPlayerRepository $lineupPlayerRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->lineupRepository = $lineupRepository;
        $this->lineupPlayerRepository = $lineupPlayerRepository;
    }

    public function savePlayersForLineup(
        array $playerIds,
        TeamLineup $lineup,
        TeamLineupPlayerCollection $teamLineupCollection
    ) {
        if (!$playerIds) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too few players selected'));
        }

        $players = $this->playerRepository->getByIdsAndTeam($playerIds, $lineup->teamId);

        if ($players->count() < LineupValidatorService::MIN_REQUIRED_PLAYERS) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too few players selected'));
        }
    }
}