<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use OSM\Core\Models\Player;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Models\TeamLineupPlayer;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Frontend\Modules\Lineup\Exceptions\LineupValidationException;

class LineupSavingService
{
    private TeamLineupPlayerRepository $lineupPlayerRepository;
    private LineupSavingValidatorService $validatorService;

    public function __construct(
        LineupSavingValidatorService $validatorService,
        TeamLineupPlayerRepository $lineupPlayerRepository
    ) {
        $this->lineupPlayerRepository = $lineupPlayerRepository;
        $this->validatorService = $validatorService;
    }

    /**
     * @throws LineupValidationException
     */
    public function savePlayersForLineup(
        array $playerIds,
        TeamLineup $lineup
    ) {
        $players = $this->validatorService->validate($playerIds, $lineup);

        $lineupPlayers = $this->lineupPlayerRepository->findByLineupId($lineup->id);

        // remove missing
        $missing = $lineupPlayers
            ->filter(fn(TeamLineupPlayer $lineupPlayer) => !in_array($lineupPlayer->playerId, $players->getIds()));

        if ($missing->isNotEmpty()) {
            $this->lineupPlayerRepository->removePlayerIdsFromLineup($missing->getPlayerIds(), $lineup->id);
        }

        // add new
        $new = $players
            ->filter(fn(Player $player) => !in_array($player->id, $lineupPlayers->getPlayerIds()));

        if ($new->isNotEmpty()) {
            $this->lineupPlayerRepository->addPlayerIdsToLineup($new->getIds(), $lineup->id);
        }
    }
}