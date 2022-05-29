<?php

declare(strict_types=1);

namespace Tests\Modules\Frontend\Lineup;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Factories\GenericFactory;
use OSM\Core\Models\Player;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Frontend\Modules\Lineup\Exceptions\LineupValidationException;
use OSM\Frontend\Modules\Lineup\Services\LineupSavingValidatorService;
use Tests\Bootstrap\BaseUnitTestCase;
use Tests\Helpers\FakeFactories\FakePlayerFactory;
use Tests\Helpers\FakeFactories\FakeTeamLineupFactory;

class LineupSavingValidatorServiceTest extends BaseUnitTestCase
{
    private GenericFactory $genericFactory;
    private LineupSavingValidatorService $sut;
    private PlayerRepository $playerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->genericFactory = \Mockery::mock(GenericFactory::class);
        $this->playerRepository = \Mockery::mock(PlayerRepository::class);

        $this->genericFactory->shouldReceive('get')->andReturn($this->playerRepository);

        $this->sut = new LineupSavingValidatorService($this->genericFactory);
    }

    public function testLineupValidation_withCorrectData_succeeds()
    {
        $this->playerRepository->shouldReceive('findByIdsAndTeam')->andReturn($this->createFakePlayerCollection());

        $playerIds = [1, 2, 3, 4, 5];
        $teamLineup = FakeTeamLineupFactory::create();

        $playerCollection = $this->sut->validate($playerIds, $teamLineup);

        $this->assertTrue($playerCollection->isNotEmpty());
    }

    public function testLineupValidation_withTooManyPlayers_shouldFail()
    {
        $this->expectException(LineupValidationException::class);
        $this->expectExceptionMessage('Too many players selected');

        $invalidCollection = $this->createFakePlayerCollection();
        $invalidCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_G]));

        $this->playerRepository->shouldReceive('findByIdsAndTeam')->andReturn($invalidCollection);

        $this->sut->validate([1, 2, 3], FakeTeamLineupFactory::create());
    }

    public function testLineupValidation_withTooFewPlayers_shouldFail()
    {
        $this->expectException(LineupValidationException::class);
        $this->expectExceptionMessage('Too few players selected');

        $invalidCollection = new PlayerCollection();
        $invalidCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_G]));

        $this->playerRepository->shouldReceive('findByIdsAndTeam')->andReturn($invalidCollection);

        $this->sut->validate([1, 2, 3], FakeTeamLineupFactory::create());
    }

    public function testLineupValidation_withTwoGoalkeepers_shouldFail()
    {
        $this->expectException(LineupValidationException::class);
        $this->expectExceptionMessage('Incorrect number of goalkeepers');

        $playerCollection = $this->createFakePlayerCollection()->removeByPosition(Player::POSITION_D, 1);
        $playerCollection->add(FakePlayerFactory::createForPosition(Player::POSITION_G));

        $this->playerRepository->shouldReceive('findByIdsAndTeam')->andReturn($playerCollection);

        $this->sut->validate([1, 2, 3], FakeTeamLineupFactory::create());
    }

    private function createFakePlayerCollection(): PlayerCollection
    {
        $playerCollection = new PlayerCollection();
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_G]));

        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_D]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_D]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_D]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_D]));

        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_M]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_M]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_M]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_M]));

        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_F]));
        $playerCollection->add(FakePlayerFactory::create(['position' => Player::POSITION_F]));

        return $playerCollection;
    }
}