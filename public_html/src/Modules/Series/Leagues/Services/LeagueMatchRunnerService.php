<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Models\Championship;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\Match;
use OSM\Modules\Matches\Factories\MatchParameterFactory;
use OSM\Modules\Matches\Services\MatchRunnerService;

class LeagueMatchRunnerService
{
    private LeagueAttendanceCalculationService $attendanceCalculationService;
    private MatchRunnerService $matchRunnerService;
    private MatchParameterFactory $matchParameterFactory;

    public function __construct(
        LeagueAttendanceCalculationService $attendanceCalculationService,
        MatchParameterFactory $matchParameterFactory,
        MatchRunnerService $matchRunnerService
    ) {
        $this->attendanceCalculationService = $attendanceCalculationService;
        $this->matchRunnerService = $matchRunnerService;
        $this->matchParameterFactory = $matchParameterFactory;
    }

    public function runLeagueMatch(
        Match $match,
        ChampionshipLeague $league,
        Championship $championship
    ) {
        $parameters = $this->matchParameterFactory->buildForMatch($match);

        // todo remove in production
        $parameters->setIsDryRun(true);

        $this->matchRunnerService->runMatch($match, $parameters);
    }
}
