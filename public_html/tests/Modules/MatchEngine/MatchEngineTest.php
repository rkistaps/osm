<?php

declare(strict_types=1);

namespace Tests\Modules\MatchEngine;

use OSM\Modules\MatchEngine\MatchEngine;
use OSM\Modules\MatchEngine\Services\InjuryService;
use OSM\Modules\MatchEngine\Services\LineupStrengthCalculatorService;
use OSM\Modules\MatchEngine\Services\LineupValidatorService;
use OSM\Modules\MatchEngine\Services\PenaltyService;
use OSM\Modules\MatchEngine\Services\PerformanceCalculatorService;
use OSM\Modules\MatchEngine\Services\PossessionCalculatorService;
use OSM\Modules\MatchEngine\Services\ShootCalculatorService;
use OSM\Modules\MatchEngine\Structures\MatchResult;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use Tests\Bootstrap\BaseUnitTestCase;
use Tests\Modules\MatchEngine\Helpers\TestDataHelper;

class MatchEngineTest extends BaseUnitTestCase
{
    private MatchEngine $sut;

    public function setUp(): void
    {
        $possessionCalculator = new PossessionCalculatorService();
        $lineupStrengthCalculator = new LineupStrengthCalculatorService();
        $performanceCalculator = new PerformanceCalculatorService();
        $shootCalculator = new ShootCalculatorService();
        $validatorService = new LineupValidatorService();
        $injuryService = new InjuryService();
        $penaltyService = new PenaltyService();

        $this->sut = new MatchEngine(
            $possessionCalculator,
            $lineupStrengthCalculator,
            $performanceCalculator,
            $shootCalculator,
            $validatorService,
            $injuryService,
            $penaltyService
        );

        parent::setUp();
    }

    public function testMatchEngine_withCorrectData_returnsCorrectResult()
    {
        $homeTeam = TestDataHelper::getLineup(1);
        $awayTeam = TestDataHelper::getLineup(2);
        $settings = new MatchSettings();

        $result = $this->sut->playMatch($homeTeam, $awayTeam, $settings);

        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertNotEmpty($result->events);
    }

    public function testMatchEngine_withMissingPlayers_ReturnsWalkover()
    {
        $homeTeam = TestDataHelper::getLineup(1);
        $awayTeam = TestDataHelper::getLineup(2);
        $awayTeam->players = [];
        $settings = new MatchSettings();

        $result = $this->sut->playMatch($homeTeam, $awayTeam, $settings);

        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertTrue($result->isAwayTeamWalkover);
    }
}
