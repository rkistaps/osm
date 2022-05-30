<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use OSM\Core\Models\Team;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Frontend\Modules\Lineup\Exceptions\TacticValidationException;
use OSM\Frontend\Modules\Lineup\Structures\SaveTacticsParameters;

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
    public function processSave(SaveTacticsParameters $parameters, Team $team): bool
    {
        if (!isset(TeamLineup::getAvailableTactics()[$parameters->tactic])) {
            throw new TacticValidationException(_f('Invalid tactic'));
        }

        if (!isset(TeamLineup::getAvailablePassingStyles()[$parameters->passingStyle])) {
            throw new TacticValidationException(_f('Invalid passing style'));
        }

        if (!isset(TeamLineup::getAvailableDefensiveLines()[$parameters->defensiveLine])) {
            throw new TacticValidationException(_f('Invalid defensive line'));
        }

        if (!isset(TeamLineup::getAvailablePressures()[$parameters->pressure])) {
            throw new TacticValidationException(_f('Invalid pressure'));
        }

        $lineup = $this->lineupSessionService->getOrSet($team);

        $lineup->tactic = $parameters->tactic;
        $lineup->passingStyle = $parameters->passingStyle;
        $lineup->defensiveLine = $parameters->defensiveLine;
        $lineup->pressure = $parameters->pressure;

        $this->teamLineupRepository->saveModel($lineup);

        return true;
    }
}