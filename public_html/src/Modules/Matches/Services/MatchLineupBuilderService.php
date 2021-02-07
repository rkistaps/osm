<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use OSM\Core\Models\Match;
use OSM\Core\Models\Player;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\Player as MatchPlayer;
use OSM\Modules\Matches\Structures\MatchParameters;

class MatchLineupBuilderService
{
    private TeamLineupRepository $teamLineupRepository;
    private PlayerRepository $playerRepository;

    public function __construct(
        TeamLineupRepository $teamLineupRepository,
        PlayerRepository $playerRepository
    ) {
        $this->teamLineupRepository = $teamLineupRepository;
        $this->playerRepository = $playerRepository;
    }

    public function buildHomeTeamLineup(Match $match, MatchParameters $matchParameters): Lineup
    {
        return $this->buildLineupForTeamId($match->homeTeamId, $matchParameters, $match->homeTeamLineupId);
    }

    public function buildAwayTeamLineup(Match $match, MatchParameters $matchParameters): Lineup
    {
        return $this->buildLineupForTeamId($match->awayTeamId, $matchParameters, $match->awayTeamLineupId);
    }

    protected function buildLineupForTeamId(
        int $teamId,
        MatchParameters $matchParameters,
        int $lineupId = null
    ): Lineup {
        $lineup = new Lineup();
        $lineup->teamId = $teamId;

        $teamLineup = $lineupId
            ? $this->teamLineupRepository->findById($lineupId)
            : $this->teamLineupRepository->getDefaultForTeamId($teamId);

        if (!$teamLineup && $lineupId) {
            $teamLineup = $this->teamLineupRepository->getDefaultForTeamId($teamId);
        }

        if (!$teamLineup) {
            return $lineup;
        }

        $lineup->players = $this->getPlayersForTeamLineup($teamId, $teamLineup, $matchParameters);

        $lineup->pressure = $teamLineup->pressure;
        $lineup->passingStyle = $teamLineup->passingStyle;
        $lineup->defensiveLine = $teamLineup->defensiveLine;
        $lineup->tactic = $teamLineup->tactic;

        // todo coach
        $lineup->coach = null;

        return $lineup;
    }

    protected function getPlayersForTeamLineup(
        int $teamId,
        TeamLineup $teamLineup,
        MatchParameters $matchParameters
    ): array {
        $playerCollection = $this
            ->playerRepository
            ->getPlayersForTeamLineupId($teamLineup->id)
            ->filter(function (Player $player) use ($teamId) {
                if ($teamId !== $player->teamId) {
                    return false;
                }

                if ($player->injuryDays > 0) {
                    return false;
                }

                return true;
            });

        return array_map(function (Player $player) use ($matchParameters) {
            $matchPlayer = new MatchPlayer();

            $matchPlayer->id = $player->id;
            $matchPlayer->speciality = $player->speciality;
            $matchPlayer->position = $player->position;
            $matchPlayer->skill = (int)$player->skill;
            $matchPlayer->age = $player->age;
            $matchPlayer->energy = $matchParameters->useFullEnergy
                ? 100
                : $player->energy;

            $matchPlayer->experience = $player->experience;
            $matchPlayer->status = MatchPlayer::STATUS_STARTING;

            return $matchPlayer;
        }, $playerCollection->all());
    }
}
