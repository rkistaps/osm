<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use OSM\Core\Models\Match;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\MatchEngine\MatchEngine;
use OSM\Modules\MatchEngine\Structures\MatchResult;
use OSM\Modules\Matches\Structures\MatchParameters;

class MatchRunnerService
{
    private MatchEngine $matchEngine;
    private MatchLineupBuilderService $lineupBuilderService;
    private TeamRepository $teamRepository;

    public function __construct(
        MatchEngine $matchEngine,
        MatchLineupBuilderService $lineupBuilderService,
        TeamRepository $teamRepository
    ) {
        $this->matchEngine = $matchEngine;
        $this->lineupBuilderService = $lineupBuilderService;
        $this->teamRepository = $teamRepository;
    }

    public function runMatch(Match $match, MatchParameters $matchParameters): MatchResult
    {
        $homeTeamLineup = $this->lineupBuilderService->buildHomeTeamLineup($match, $matchParameters);
        $awayTeamLineup = $this->lineupBuilderService->buildAwayTeamLineup($match, $matchParameters);
    }
}
