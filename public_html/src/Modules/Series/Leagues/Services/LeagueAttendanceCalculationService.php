<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Collections\MatchCollection;
use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\ChampionshipTableRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Series\Common\Structures\MatchAttendanceCollection;
use OSM\Modules\Series\Leagues\Structures\MatchAttendanceParameters;

class LeagueAttendanceCalculationService
{
    private const MAX_HOME_FANS = 40000;
    private const MAX_AWAY_FANS = 4000;

    private TeamRepository $teamRepository;
    private ChampionshipTableRepository $tableRepository;

    public function __construct(
        TeamRepository $teamRepository,
        ChampionshipTableRepository $tableRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->tableRepository = $tableRepository;
    }

    public function calculateAttendanceForMatches(
        MatchCollection $matchCollection,
        ChampionshipLeague $league
    ): MatchAttendanceCollection {
        $teams = $this->teamRepository->findByIds($matchCollection->getTeamIds());
        $tableRows = $this->tableRepository->findByTeamIdsAndLeague(
            $matchCollection->getTeamIds(),
            $league
        );

        $parameters = new MatchAttendanceParameters();
        $parameters
            ->setLevel($league->level)
            ->setHardness($league->hardness);

        $matchAttendanceCollection = new MatchAttendanceCollection();

        foreach ($matchCollection->all() as $match) {
            $homeTeamTableRow = $tableRows->getByTeamId($match->homeTeamId);
            $awayTeamTableRow = $tableRows->getByTeamId($match->awayTeamId);

            $homeTeam = $teams->getById($match->homeTeamId);
            $awayTeam = $teams->getById($match->awayTeamId);

            $parameters->setTicketPriceLevel($match->ticketPriceLevel);

            $parameters->setHomeFans($homeTeam->supporters);
            $parameters->setAwayFans($awayTeam->supporters);

            $parameters->setHomeTeamPlacement($homeTeamTableRow->place);
            $parameters->setAwayTeamPlacement($awayTeamTableRow->place);

            $attendance = $this->calculateAttendanceByParameters($parameters);

            // todo implement staff

            $matchAttendanceCollection->addMatchAttendance($match, $attendance);
        }

        return $matchAttendanceCollection;
    }

    public function calculateAttendanceByParameters(MatchAttendanceParameters $parameters): int
    {
        $attendance = 0;

        $levelMultiplier = $parameters->level < 4
            ? (4 - $parameters->level)
            : 0;

        $attendance += 5000 * $levelMultiplier;
        $attendance += (20 - $parameters->homeTeamPlacement - $parameters->awayTeamPlacement) * 1000;
        $attendance += $parameters->hardness * $parameters->hardness / 5;

        $attendance += ($parameters->homeFans > self::MAX_HOME_FANS) ? self::MAX_HOME_FANS : $parameters->homeFans;
        $attendance += ($parameters->awayFans > self::MAX_AWAY_FANS) ? self::MAX_AWAY_FANS : $parameters->awayFans;

        $ticketPriceMap = [
            Match::TICKET_PRICE_LEVEL_VERY_LOW => RandomHelper::between(1.1, 1.2),
            Match::TICKET_PRICE_LEVEL_LOW => RandomHelper::between(1.05, 1.1),
            Match::TICKET_PRICE_LEVEL_NORMAL => RandomHelper::between(0.95, 1.05),
            Match::TICKET_PRICE_LEVEL_HIGH => RandomHelper::between(0.9, 0.95),
            Match::TICKET_PRICE_LEVEL_VERY_HIGH => RandomHelper::between(0.8, 0.9),
        ];

        $attendance *= $ticketPriceMap[$parameters->ticketPriceLevel] ?? 1;
        $attendance *= (1 + $parameters->staffLevel * 0.02);

        $attendance *= $parameters->multiplier;

        return (int)round($attendance * RandomHelper::between(90, 110) / 100);
    }
}
