<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use OSM\Core\Models\Match;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Modules\MatchEngine\Structures\Injury;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\Matches\Structures\MatchParameters;
use OSM\Modules\Options\Services\OptionValueService;
use OSM\Modules\Options\Structures\PlayerOptionGroup;

/**
 * This service processes lineup after match
 */
class AfterMatchLineupProcessorService
{
    private const MIN_ENERGY = 5; // 5%

    private MatchEnergyLossCalculationService $energyLossCalculationService;
    private MatchPlayerStatsUpdateService $playerStatsUpdateService;
    private PlayerRepository $playerRepository;
    private OptionValueService $optionValueService;

    public function __construct(
        MatchEnergyLossCalculationService $energyLossCalculationService,
        MatchPlayerStatsUpdateService $playerStatsUpdateService,
        PlayerRepository $playerRepository,
        OptionValueService $optionValueService
    ) {
        $this->energyLossCalculationService = $energyLossCalculationService;
        $this->playerStatsUpdateService = $playerStatsUpdateService;
        $this->playerRepository = $playerRepository;
        $this->optionValueService = $optionValueService;
    }

    public function processLineup(
        Match $match,
        Lineup $lineup,
        MatchParameters $matchParameters
    ) {
        if ($matchParameters->processFatigue) {
            $this->processLineupFatigue($lineup);
        }

        if ($matchParameters->processPlayerStats) {
            $this->playerStatsUpdateService->processLineup($lineup, $match->seriesType);
        }

        // update player models

        $playerIds = collect($lineup->players)->pluck('id')->all();
        $playerCollection = $this->playerRepository->findAll(['id' => $playerIds]);
        foreach ($lineup->players as $player) {
            $playerModel = $playerCollection->firstWhere('id', $player->id);
            if (!$playerModel) {
                continue;
            }

            $playerModel->energy = $player->energy;

            if ($matchParameters->processInjuries) {
                $playerModel->injuryDays = $player->isInjured()
                    ? $this->getInjuryDaysFromInjury($player->injury)
                    : 0;
            }

            $player->experience += $player->experience;
            $expLimit = $this->optionValueService->getOptionValue(PlayerOptionGroup::OPTION_EXPERIENCE_LIMIT);
            $player->experience = $player->experience > $expLimit
                ? $expLimit
                : $player->experience;

            $this->playerRepository->saveModel($playerModel, [
                'energy',
                'injury_days',
                'experience',
            ]);
        }
    }

    protected function processLineupFatigue(Lineup $lineup)
    {
        foreach ($lineup->players as $player) {
            $player->energy -= $this->energyLossCalculationService->calculateEnergyLoss($player, $lineup->pressure);
            $player->energy = $player->energy < self::MIN_ENERGY ? self::MIN_ENERGY : $player->energy;
        }
    }


    public function getInjuryDaysFromInjury(Injury $injury): int
    {
        $map = [
            Injury::SEVERITY_LOW => rand(1, 2),
            Injury::SEVERITY_MINOR => rand(2, 4),
            Injury::SEVERITY_AVERAGE => rand(4, 6),
            Injury::SEVERITY_HIGH => rand(4, 10),
        ];

        return $map[$injury->severity];
    }
}
