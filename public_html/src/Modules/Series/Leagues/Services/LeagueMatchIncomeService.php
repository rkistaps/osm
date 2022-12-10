<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Collections\MatchCollection;
use OSM\Core\Models\Championship;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\FinanceLog;
use OSM\Core\Models\Match;
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
        ChampionshipLeague $league
    ) {
        $attendances = $this->attendanceCalculationService->calculateAttendanceForMatches(
            $matchCollection,
            $league
        );

        $homeTeams = $this->teamRepository->findByIds($matchCollection->getHomeTeamIds());

        foreach ($matchCollection->all() as $match) {
            $attendance = $attendances->getMatchAttendance($match);
            $homeTeam = $homeTeams->getById($match->homeTeamId);

            // do not exceed stadium size
            $attendance = min($attendance, $homeTeam->stadiumSize);
            $income = $attendance * $this->getTicketPriceForMatch($match);

            $this->financialService->depositFunds($income, FinanceLog::EVENT_MATCH_INCOME, $homeTeam, true);

            // todo process rest match income sources - snack, boards etc
        }
    }

    public function getTicketPriceForMatch(Match $match): float
    {
        $map = [
            Match::TICKET_PRICE_LEVEL_VERY_LOW => 4,
            Match::TICKET_PRICE_LEVEL_LOW => 4.5,
            Match::TICKET_PRICE_LEVEL_NORMAL => 5,
            Match::TICKET_PRICE_LEVEL_HIGH => 5.5,
            Match::TICKET_PRICE_LEVEL_VERY_HIGH => 6,
        ];

        return $map[$match->ticketPriceLevel] ?? 5;
    }
}
