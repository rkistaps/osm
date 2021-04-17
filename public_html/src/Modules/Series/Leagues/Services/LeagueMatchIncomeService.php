<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Collections\MatchCollection;
use OSM\Core\Models\Championship;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Teams\Finances\Services\TeamFinancialService;

class LeagueMatchIncomeService
{
    private TeamFinancialService $financialService;
    private LeagueAttendanceCalculationService $attendanceCalculationService;
    private TeamRepository $teamRepository;

    public function __construct(
        TeamFinancialService $financialService,
        TeamRepository $teamRepository,
        LeagueAttendanceCalculationService $attendanceCalculationService
    ) {
        $this->financialService = $financialService;
        $this->attendanceCalculationService = $attendanceCalculationService;
        $this->teamRepository = $teamRepository;
    }

    public function processMatchIncome(
        MatchCollection $matchCollection,
        Championship $championship,
        ChampionshipLeague $league
    ) {
        $attendances = $this->attendanceCalculationService->calculateAttendanceForMatches(
            $matchCollection,
            $league
        );

        foreach ($matchCollection->all() as $match) {
            $attendance = $attendances->getMatchAttendance($match);


        }


    }
}
