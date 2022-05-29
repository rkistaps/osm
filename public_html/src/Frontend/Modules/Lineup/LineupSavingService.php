<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup;

use OSM\Core\Models\Player;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Models\TeamLineupPlayer;
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
        TeamLineup $lineup
    ) {
        if (!$playerIds) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too few players selected'));
        }

        $players = $this->playerRepository->findByIdsAndTeam($playerIds, $lineup->teamId);

        if ($players->count() < LineupValidatorService::MIN_REQUIRED_PLAYERS) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too few players selected'));
        }

        $lineupPlayers = $this->lineupPlayerRepository->findByLineupId($lineup->id);

        // remove missing
        $missing = $lineupPlayers
            ->filter(fn(TeamLineupPlayer $lineupPlayer) => !in_array($lineupPlayer->playerId, $players->getIds()));

        if ($missing->isNotEmpty()) {
            $this->lineupPlayerRepository->removePlayerIdsFromLineup($missing->getPlayerIds(), $lineup->id);
        }

        // add new
        $new = $players
            ->filter(fn(Player $player) => !in_array($player->id, $lineupPlayers->getPlayerIds()))
            ->all();

        if (!empty($new)) {
            foreach ($new as $newPlayer) {
                $this->lineupPlayerRepository->createModel([
                    'player_id' => $newPlayer->id,
                    'team_lineup_id' => $lineup->id,
                ], true);
            }
        }
    }
}