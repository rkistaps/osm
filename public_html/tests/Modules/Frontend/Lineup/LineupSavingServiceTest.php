<?php

declare(strict_types=1);

namespace Tests\Modules\Frontend\Lineup;

use Mockery;
use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Collections\TeamLineupPlayerCollection;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Frontend\Modules\Lineup\LineupSavingService;
use Tests\Bootstrap\BaseUnitTestCase;
use Tests\Helpers\FakeFactories\FakePlayerFactory;
use Tests\Helpers\FakeFactories\FakeTeamLineupFactory;

class LineupSavingServiceTest extends BaseUnitTestCase
{
    private LineupSavingService $sut;
    private PlayerRepository $playerRepo;
    private TeamLineupRepository $teamLineupRepo;
    private TeamLineupPlayerRepository $teamLineupPlayerRepo;

    protected function setUp(): void
    {
        parent::setUp();


        $this->playerRepo = Mockery::mock(PlayerRepository::class);
        $this->teamLineupRepo = Mockery::mock(TeamLineupRepository::class);
        $this->teamLineupPlayerRepo = Mockery::mock(TeamLineupPlayerRepository::class);
        $this->sut = new LineupSavingService(
            $this->playerRepo,
            $this->teamLineupRepo,
            $this->teamLineupPlayerRepo
        );
    }

    public function testSavingPlayersForLineup_withCorrectData_lineupSaves()
    {
        $player = FakePlayerFactory::create([
            'id' => 100,
        ]);

        $this->playerRepo->shouldReceive('findByIdsAndTeam')->andReturn(new PlayerCollection());

        $lineup = FakeTeamLineupFactory::create(['name' => 'real']);
        dd($lineup);
        $playerLineupCollection = new TeamLineupPlayerCollection();

        $this->sut->savePlayersForLineup(
            [1,2,3],
            $lineup,
            $playerLineupCollection
        );
    }
}