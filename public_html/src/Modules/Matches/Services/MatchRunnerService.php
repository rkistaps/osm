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
    private MatchReportSavingService $matchReportService;

    public function __construct(
        MatchEngine $matchEngine,
        MatchLineupBuilderService $lineupBuilderService,
        TeamRepository $teamRepository,
        MatchReportSavingService $matchReportService
    ) {
        $this->matchEngine = $matchEngine;
        $this->lineupBuilderService = $lineupBuilderService;
        $this->teamRepository = $teamRepository;
        $this->matchReportService = $matchReportService;
    }

    public function runMatch(Match $match, MatchParameters $matchParameters): MatchResult
    {
        $homeTeamLineup = $this->lineupBuilderService->buildHomeTeamLineup($match, $matchParameters);
        $awayTeamLineup = $this->lineupBuilderService->buildAwayTeamLineup($match, $matchParameters);

        $matchResult = $this->matchEngine->playMatch(
            $homeTeamLineup,
            $awayTeamLineup,
            $matchParameters->matchSettings
        );

        $match->isPlayed = true;
        $match->isWalkover = $matchResult->isWalkover();
        $match->homeTeamGoals = $matchResult->stats->homeTeamGoals;
        $match->awayTeamGoals = $matchResult->stats->awayTeamGoals;

        if ($matchParameters->isDryRun) {
            return $matchResult;
        }

        $this->matchReportService->saveMatchReport($match, $matchResult);

        return $matchResult;
    }
}
