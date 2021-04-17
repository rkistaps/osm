<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

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

    public function runLeagueMatch(Match $match)
    {
        $parameters = $this->matchParameterFactory->buildForMatch($match);

        $this->matchRunnerService->runMatch($match, $parameters);
    }
}
