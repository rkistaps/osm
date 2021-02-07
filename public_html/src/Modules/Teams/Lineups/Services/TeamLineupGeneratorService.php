<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Lineups\Services;

use OSM\Core\Models\Player;
use OSM\Core\Models\Team;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Modules\Players\Calculators\PlayerStrengthCalculator;

class TeamLineupGeneratorService
{
    private TeamLineupRepository $lineupRepository;
    private TeamLineupPlayerRepository $lineupPlayerRepository;
    private PlayerRepository $playerRepository;
    private PlayerStrengthCalculator $playerStrengthCalculator;

    public function __construct(
        TeamLineupRepository $lineupRepository,
        TeamLineupPlayerRepository $lineupPlayerRepository,
        PlayerRepository $playerRepository,
        PlayerStrengthCalculator $playerStrengthCalculator
    ) {
        $this->lineupRepository = $lineupRepository;
        $this->lineupPlayerRepository = $lineupPlayerRepository;
        $this->playerRepository = $playerRepository;
        $this->playerStrengthCalculator = $playerStrengthCalculator;
    }

    public function generateDefaultLineup(Team $team): TeamLineup
    {
        $this->lineupRepository->removeDefaultLineupForTeam($team->id);

        $lineup = new TeamLineup();
        $lineup->teamId = $team->id;
        $lineup->isDefault = true;
        $lineup->name = 'Default';

        $this->lineupRepository->saveModel($lineup);

        $this->setBestPlayersForLineup($lineup);

        return $lineup;
    }

    public function setBestPlayersForLineup(TeamLineup $lineup)
    {
        $players = $this
            ->playerRepository
            ->getSquadPlayersByTeam($lineup->teamId)
            ->sort(fn(Player $player) => $this->playerStrengthCalculator->calculateStrength($player))
            ->all();

        $playerIds = [];

        // add goalkeeper first
        /** @var Player $goalkeeper */
        $goalkeeper = collect($players)->firstWhere('position', Player::POSITION_G);
        if ($goalkeeper) {
            $playerIds[] = $goalkeeper->id;
        }

        // Player count limit per position
        $playerPositionLimits = [
            Player::POSITION_D => 5,
            Player::POSITION_M => 5,
            Player::POSITION_F => 3,
        ];
        foreach ($players as $player) {
            if ($playerPositionLimits[$player->position] < 1) { // no more spots in this position
                continue;
            }

            // add player to lineup
            $playerIds[] = $player->id;

            // remove one spot for position
            $playerPositionLimits[$player->position] -= 1;

            // we are set
            if (count($playerIds) === 11) {
                break;
            }
        }

        $this->setLineupPlayers($lineup->id, $playerIds);
    }

    public function setLineupPlayers(int $lineupId, array $playerIds)
    {
        $currentPlayersIds = $this
            ->lineupPlayerRepository
            ->findByLineupId($lineupId)
            ->pluck('player_id')
            ->all();

        // add new
        foreach ($playerIds as $playerId) {
            if (!in_array($playerId, $currentPlayersIds)) {
                $this->lineupPlayerRepository->createModel([
                    'team_lineup_id' => $lineupId,
                    'player_id' => $playerId,
                ], true);
            }
        }

        // find missing
        $idsToDelete = [];
        foreach ($currentPlayersIds as $currentId) {
            if (!in_array($currentId, $playerIds)) {
                $idsToDelete[] = $currentId;
            }
        }

        // remove missing
        if ($idsToDelete) {
            $this->lineupPlayerRepository->removePlayerIdsFromLineup($idsToDelete, $lineupId);
        }
    }
}
