<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use OSM\Core\Models\Match;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\MatchEngine\Interfaces\MatchEngineInterface;
use OSM\Modules\MatchEngine\Structures\MatchResult;
use OSM\Modules\Matches\Structures\MatchParameters;

class MatchRunnerService
{
    private MatchLineupBuilderService $lineupBuilderService;
    private MatchReportSavingService $matchReportService;
    private AfterMatchLineupProcessorService $matchLineupProcessorService;
    private MatchRepository $matchRepository;

    public function __construct(
        MatchLineupBuilderService $lineupBuilderService,
        MatchReportSavingService $matchReportService,
        AfterMatchLineupProcessorService $matchLineupProcessorService,
        MatchRepository $matchRepository
    ) {
        $this->lineupBuilderService = $lineupBuilderService;
        $this->matchReportService = $matchReportService;
        $this->matchLineupProcessorService = $matchLineupProcessorService;
        $this->matchRepository = $matchRepository;
    }

    public function runMatch(
        MatchEngineInterface $matchEngine,
        Match $match,
        MatchParameters $matchParameters
    ): MatchResult {
        $homeTeamLineup = $this->lineupBuilderService->buildHomeTeamLineup($match, $matchParameters);
        $awayTeamLineup = $this->lineupBuilderService->buildAwayTeamLineup($match, $matchParameters);

        $matchResult = $matchEngine->playMatch(
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

        $this->matchLineupProcessorService->processLineup($match, $homeTeamLineup, $matchParameters);
        $this->matchLineupProcessorService->processLineup($match, $awayTeamLineup, $matchParameters);

        $this->matchRepository->saveModel($match);

        return $matchResult;
    }
}
