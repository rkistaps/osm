<?php

declare(strict_types=1);

namespace Tests\Modules\Series\Leagues\Services;

use OSM\Core\Collections\ChampionshipTableCollection;
use OSM\Core\Collections\MatchCollection;
use OSM\Core\Collections\TeamCollection;
use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\ChampionshipTable;
use OSM\Core\Models\Match;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\ChampionshipTableRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Series\Leagues\Services\LeagueAttendanceCalculationService;
use OSM\Modules\Series\Leagues\Structures\MatchAttendanceParameters;
use PHPUnit\Framework\TestCase;

class LeagueAttendanceCalculationServiceTest extends TestCase
{
    private LeagueAttendanceCalculationService $sut;
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|TeamRepository
     */
    private $teamRepository;
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|ChampionshipTableRepository
     */
    private $tableRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamRepository = \Mockery::Mock(TeamRepository::class);
        $this->tableRepository = \Mockery::Mock(ChampionshipTableRepository::class);

        $this->sut = new LeagueAttendanceCalculationService(
            $this->teamRepository,
            $this->tableRepository
        );
    }

    public function testCalculationByParams_withCorrectParams_calculatesAttendance()
    {
        $parameters = (new MatchAttendanceParameters())
            ->setAwayFans(1000)
            ->setHomeFans(1000)
            ->setHomeTeamPlacement(1)
            ->setAwayTeamPlacement(1)
            ->setHardness(100)
            ->setLevel(1)
            ->setStaffLevel(2)
            ->setTicketPriceLevel(Match::TICKET_PRICE_LEVEL_HIGH);

        $attendance = $this->sut->calculateAttendanceByParameters($parameters);

        $this->assertGreaterThan(0, $attendance);
    }

    public function testAttendanceCalculation_withACollectionOfMatches_calculatesAttendanceForEveryMatch()
    {
        $tableCollection = new ChampionshipTableCollection();
        $teamCollection = new TeamCollection();
        for ($i = 1; $i < 7; $i++) {
            $team = new Team();
            $team->id = $i;
            $team->supporters = RandomHelper::between(100, 5000);
            $teamCollection->add($team);

            $tableRow = new ChampionshipTable();
            $tableRow->teamId = $i;
            $tableRow->place = 11 - $i;
            $tableCollection->add($tableRow);
        }

        $matchCollection = new MatchCollection();

        $match = new Match();
        $match->id = 1;
        $match->homeTeamId = 1;
        $match->awayTeamId = 2;
        $matchCollection->add($match);

        $match = new Match();
        $match->id = 2;
        $match->homeTeamId = 3;
        $match->awayTeamId = 4;
        $matchCollection->add($match);

        $match = new Match();
        $match->id = 3;
        $match->homeTeamId = 5;
        $match->awayTeamId = 6;
        $matchCollection->add($match);

        $league = new ChampionshipLeague();
        $league->hardness = 100;
        $league->level = 1;

        $this->teamRepository->shouldReceive('findByIds')->once()->andReturn($teamCollection);
        $this->tableRepository->shouldReceive('findByTeamIdsAndLeague')->once()->andReturn($tableCollection);

        # test sut
        $attendances = $this->sut->calculateAttendanceForMatches($matchCollection, $league);

        foreach ($matchCollection->all() as $match) {
            $matchAttendance = $attendances->getMatchAttendance($match);

            // assert every match has an attendance calculated
            $this->assertIsInt($matchAttendance);
            $this->assertGreaterThan(0, $matchAttendance);
        }
    }
}
