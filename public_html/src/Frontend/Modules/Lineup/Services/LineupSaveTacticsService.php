<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use OSM\Core\Models\Team;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Frontend\Modules\Lineup\Exceptions\TacticValidationException;

class LineupSaveTacticsService
{
    private TeamLineupSessionService $lineupSessionService;
    private TeamLineupRepository $teamLineupRepository;

    public function __construct(
        TeamLineupSessionService $lineupSessionService,
        TeamLineupRepository $teamLineupRepository
    ) {
        $this->lineupSessionService = $lineupSessionService;
        $this->teamLineupRepository = $teamLineupRepository;
    }

    /**
     * @throws TacticValidationException
     */
    public function processSave(?string $tactic, Team $team): bool
    {
        if (!$tactic || !isset(TeamLineup::getAvailableTactics()[$tactic])) {
            throw new TacticValidationException(_f('Invalid tactic'));
        }

        $lineup = $this->lineupSessionService->getOrSet($team);

        $lineup->tactic = $tactic;
        $this->teamLineupRepository->saveModel($lineup);

        return true;
    }
}