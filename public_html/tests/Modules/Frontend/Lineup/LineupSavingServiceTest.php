<?php

declare(strict_types=1);

namespace Tests\Modules\Frontend\Lineup;

use Mockery;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Frontend\Modules\Lineup\Services\LineupSavingService;
use OSM\Frontend\Modules\Lineup\Services\LineupSavingValidatorService;
use Tests\Bootstrap\BaseUnitTestCase;
use Tests\Helpers\FakeFactories\FakePlayerCollectionFactory;
use Tests\Helpers\FakeFactories\FakeTeamLineupFactory;
use Tests\Helpers\FakeFactories\FakeTeamLineupPlayerCollectionFactory;

class LineupSavingServiceTest extends BaseUnitTestCase
{
    private LineupSavingService $sut;
    private TeamLineupPlayerRepository $teamLineupPlayerRepo;
    private LineupSavingValidatorService $validatorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamLineupPlayerRepo = Mockery::mock(TeamLineupPlayerRepository::class);
        $this->validatorService = Mockery::mock(LineupSavingValidatorService::class);

        $this->sut = new LineupSavingService(
            $this->validatorService,
            $this->teamLineupPlayerRepo
        );
    }

    public function testSavingPlayersForLineup_withCorrectData_lineupSaves()
    {
        $playerCollection = FakePlayerCollectionFactory::createForLineup();

        $this->validatorService->shouldReceive('validate')->andReturn($playerCollection);

        $lineup = FakeTeamLineupFactory::create();

        $existingPlayerCollection = FakeTeamLineupPlayerCollectionFactory::createForLineupId($lineup->id);

        $this
            ->teamLineupPlayerRepo
            ->shouldReceive('findByLineupId')
            ->andReturn($existingPlayerCollection);

        // validate removing all existing players
        $this
            ->teamLineupPlayerRepo
            ->shouldReceive('removePlayerIdsFromLineup')
            ->with($existingPlayerCollection->getPlayerIds(), $lineup->id)
            ->once();


        // validate adding all new players
        $this
            ->teamLineupPlayerRepo
            ->shouldReceive('addPlayerIdsToLineup')
            ->with($playerCollection->getIds(), $lineup->id)
            ->once();

        $result = $this->sut->savePlayersForLineup($playerCollection->getIds(), $lineup);

        $this->assertTrue($result);
    }
}