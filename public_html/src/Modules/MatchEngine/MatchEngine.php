<?php

namespace OSM\Modules\MatchEngine;

use OSM\Core\Helpers\RandomHelper;
use OSM\Modules\MatchEngine\Helpers\LineupHelper;
use OSM\Modules\MatchEngine\Helpers\MatchHelper;
use OSM\Modules\MatchEngine\Interfaces\MatchEngineInterface;
use OSM\Modules\MatchEngine\Modifiers\FlatLineupStrengthModifier;
use OSM\Modules\MatchEngine\Modifiers\RelativeLineupStrengthModifier;
use OSM\Modules\MatchEngine\Services\InjuryService;
use OSM\Modules\MatchEngine\Services\LineupStrengthCalculatorService;
use OSM\Modules\MatchEngine\Services\LineupValidatorService;
use OSM\Modules\MatchEngine\Services\PenaltyService;
use OSM\Modules\MatchEngine\Services\PerformanceCalculatorService;
use OSM\Modules\MatchEngine\Services\PossessionCalculatorService;
use OSM\Modules\MatchEngine\Services\ShootCalculatorService;
use OSM\Modules\MatchEngine\Structures\Coach;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\LineupStrength;
use OSM\Modules\MatchEngine\Structures\MatchEvent;
use OSM\Modules\MatchEngine\Structures\MatchResult;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\MatchEngine\Structures\Player;
use OSM\Modules\MatchEngine\Structures\ShootConfig;

class MatchEngine implements MatchEngineInterface
{
    private PossessionCalculatorService $possessionCalculator;
    private LineupStrengthCalculatorService $lineupStrengthCalculator;
    private ShootCalculatorService $shootCalculator;
    private LineupValidatorService $lineupValidatorService;
    private PerformanceCalculatorService $performanceCalculator;
    private InjuryService $injuryService;
    private PenaltyService $penaltyService;

    public function __construct(
        PossessionCalculatorService $possessionCalculator,
        LineupStrengthCalculatorService $lineupStrengthCalculator,
        PerformanceCalculatorService $performanceCalculator,
        ShootCalculatorService $shootCalculator,
        LineupValidatorService $lineupValidatorService,
        InjuryService $injuryService,
        PenaltyService $penaltyService
    ) {
        $this->possessionCalculator = $possessionCalculator;
        $this->lineupStrengthCalculator = $lineupStrengthCalculator;
        $this->performanceCalculator = $performanceCalculator;
        $this->shootCalculator = $shootCalculator;
        $this->lineupValidatorService = $lineupValidatorService;
        $this->injuryService = $injuryService;
        $this->penaltyService = $penaltyService;
    }

    public function playMatch(
        Lineup $homeTeam,
        Lineup $awayTeam,
        MatchSettings $matchSettings
    ): MatchResult {
        $result = new MatchResult();

        if (!$this->lineupValidatorService->validate($homeTeam)) {
            $result->isHomeTeamWalkover = true;
            return $result;
        } elseif (!$this->lineupValidatorService->validate($awayTeam)) {
            $result->isAwayTeamWalkover = true;
            return $result;
        }

        $result->homeTeamLineup = $homeTeam;
        $result->awayTeamLineup = $awayTeam;

        $this->performanceCalculator->calculateForLineup($homeTeam, $matchSettings);
        $this->performanceCalculator->calculateForLineup($awayTeam, $matchSettings);

        // process injuries
        $result->addMatchEvents($this->injuryService->processLineup($homeTeam, $matchSettings));
        $result->addMatchEvents($this->injuryService->processLineup($awayTeam, $matchSettings));

        // process penalties
        $result->addMatchEvents($this->penaltyService->processLineup($homeTeam, $matchSettings));
        $result->addMatchEvents($this->penaltyService->processLineup($awayTeam, $matchSettings));

        $homeTeam->strength = $this->lineupStrengthCalculator->calculate($homeTeam, $matchSettings);
        $awayTeam->strength = $this->lineupStrengthCalculator->calculate($awayTeam, $matchSettings);

        $this->modifyLineupStrength($homeTeam, $matchSettings);
        $this->modifyLineupStrength($awayTeam, $matchSettings);

        if ($matchSettings->hasHomeTeamBonus) {
            $this->applyHomeTeamBonus($homeTeam, $matchSettings);
        }

        // calculate possession
        $possession = $this->possessionCalculator->calculate($homeTeam->strength, $awayTeam->strength, $matchSettings);
        $result->stats->possession = $possession;

        // get total attack count for this match
        $totalAttackCount = $this->getAttackCount($matchSettings);

        // calculate attack counts
        $htAttackCount = round($totalAttackCount * $possession->homeTeam);
        $atAttackCount = round($totalAttackCount * $possession->awayTeam);

        // additional attacks
        $htAttackCount += $this->getAdditionalAttacks($homeTeam, $awayTeam);
        $atAttackCount += $this->getAdditionalAttacks($awayTeam, $homeTeam);

        $result->stats->homeTeamAttackCount = $htAttackCount;
        $result->stats->awayTeamAttackCount = $atAttackCount;

        // calculate shoot counts
        $htShootCount = $result->stats->homeTeamShootCount = $this->getShootCount(
            $homeTeam->strength,
            $awayTeam->strength,
            $htAttackCount
        );

        $atShootCount = $result->stats->awayTeamShootCount = $this->getShootCount(
            $awayTeam->strength,
            $homeTeam->strength,
            $atAttackCount
        );

        // add attack stop events
        $htAttacksStopped = $htAttackCount - $htShootCount;
        $atAttacksStopped = $atAttackCount - $atShootCount;

        // build attack stop events
        $attackStopEvents = array_merge(
            $this->buildAttackStopEvents($homeTeam, $awayTeam, $htAttacksStopped),
            $this->buildAttackStopEvents($awayTeam, $homeTeam, $atAttacksStopped)
        );

        // add attack stop events to match result
        collect($attackStopEvents)
            ->each(function (MatchEvent $event) use ($result) {
                $result->addMatchEvent($event);
            });

        // process home team shoots
        collect($this->processShoots($homeTeam, $awayTeam, $htShootCount))
            ->each(function (MatchEvent $event) use ($result, $homeTeam) {
                $result->addMatchEvent($event);

                if ($event->isGoal()) {
                    $result->stats->homeTeamGoals += 1;
                    $player = LineupHelper::getByIdFromLineup($event->getStrikerId(), $homeTeam);
                    $player->statistics->goals += 1;
                }
            });

        // process away team shoots
        collect($this->processShoots($awayTeam, $homeTeam, $atShootCount))
            ->each(function (MatchEvent $event) use ($result, $awayTeam) {
                $result->addMatchEvent($event);

                if ($event->isGoal()) {
                    $result->stats->awayTeamGoals += 1;
                    $player = LineupHelper::getByIdFromLineup($event->getStrikerId(), $awayTeam);
                    $player->statistics->goals += 1;
                }
            });

        if (!$matchSettings->allowDraw && $result->isDraw()) {
            // todo me
        }

        return $result;
    }

    protected function getAdditionalAttacks(Lineup $at, Lineup $dt): int
    {
        if ($at->isPassingMixed() && $dt->isDefensiveLineNormal()) {
            return rand(0, 1);
        } elseif ($at->isPassingLong() && $dt->isDefensiveLineNormal()) {
            return rand(0, 2);
        } elseif ($at->isPassingShort() && $dt->isDefensiveLineNormal()) {
            return rand(0, 2);
        } elseif ($at->isPassingMixed() && $dt->isDefensiveLineHigh()) {
            return rand(0, 2);
        } elseif ($at->isPassingLong() && $dt->isDefensiveLineHigh()) {
            return rand(2, 4);
        } elseif ($at->isPassingShort() && $dt->isDefensiveLineHigh()) {
            return rand(0, 1);
        } elseif ($at->isPassingMixed() && $dt->isDefensiveLineLow()) {
            return rand(0, 2);
        } elseif ($at->isPassingLong() && $dt->isDefensiveLineLow()) {
            return rand(0, 1);
        } elseif ($at->isPassingShort() && $dt->isDefensiveLineLow()) {
            return rand(2, 4);
        }

        // this should never happen
        return 0;
    }

    /**
     * @param Lineup $attackingTeam
     * @param Lineup $defendingTeam
     * @param int $count
     * @return MatchEvent[]
     */
    protected function processShoots(
        Lineup $attackingTeam,
        Lineup $defendingTeam,
        int $count
    ): array {
        $events = [];
        $saveBonus = 0;
        for ($i = $count; $i > 0; $i--) {
            $config = $this->buildShootConfig($attackingTeam, $defendingTeam);
            $config->saveBonus = $saveBonus;
            $shootResult = $this->shootCalculator->shoot($config);

            if ($shootResult->isGoal()) {
                $saveBonus = ($saveBonus <= -2) ? 0 : $saveBonus + 1;
            } else {
                $saveBonus = ($saveBonus >= 2) ? 0 : $saveBonus - 1;
            }

            $events[] = MatchEvent::fromShootResult($shootResult);
        }

        return $events;
    }

    /**
     * @param Lineup $attackingTeam
     * @param Lineup $defendingTeam
     * @return ShootConfig
     */
    protected function buildShootConfig(Lineup $attackingTeam, Lineup $defendingTeam): ShootConfig
    {
        $minute = rand(1, 93);

        $striker = $this->getStriker($attackingTeam, $minute);
        $goalkeeper = LineupHelper::getRandomPlayerInPosition($defendingTeam, Player::POS_G, $minute);

        $config = new ShootConfig();

        $config->minute = $minute;
        $config->attackingTeamId = $attackingTeam->teamId;
        $config->defendingTeamId = $defendingTeam->teamId;
        $config->striker = $striker;
        $config->goalkeeper = $goalkeeper;

        $shootTypeHelperRand = rand(1, 100);
        if ($shootTypeHelperRand <= 10) { // 10% 2v1
            $config->attackHelper = $this->getAttackHelper($attackingTeam, $minute, $striker);
        } elseif ($shootTypeHelperRand <= 20) { // 10% 1v2
            $config->defenseHelper = $this->getDefenseHelper($attackingTeam, $minute);
        } elseif ($shootTypeHelperRand <= 50) { // 30% 2v2
            $config->attackHelper = $this->getAttackHelper($attackingTeam, $minute, $striker);
            $config->defenseHelper = $this->getDefenseHelper($attackingTeam, $minute);
        }

        return $config;
    }

    protected function getAttackHelper(Lineup $lineup, int $minute, Player $striker): ?Player
    {
        $positionOrder = RandomHelper::getOneByChance([
            15 => [Player::POS_F, Player::POS_D, Player::POS_F],
            25 => [Player::POS_M, Player::POS_D, Player::POS_F],
            60 => [Player::POS_F, Player::POS_M, Player::POS_D],
        ]);

        return LineupHelper::getRandomPlayerByPositions($lineup, $minute, $positionOrder, $striker->id);
    }

    protected function getDefenseHelper(Lineup $lineup, int $minute): ?Player
    {
        $positionOrder = RandomHelper::getOneByChance([
            15 => [Player::POS_F, Player::POS_D, Player::POS_M],
            25 => [Player::POS_M, Player::POS_D, Player::POS_F],
            60 => [Player::POS_D, Player::POS_M, Player::POS_F],
        ]);

        return LineupHelper::getRandomPlayerByPositions($lineup, $minute, $positionOrder);
    }

    protected function getStriker(Lineup $lineup, int $minute): Player
    {
        $positionOrder = RandomHelper::getOneByChance([
            15 => [Player::POS_D, Player::POS_M, Player::POS_F],
            25 => [Player::POS_M, Player::POS_D, Player::POS_F],
            60 => [Player::POS_F, Player::POS_M, Player::POS_D],
        ]);

        return LineupHelper::getRandomPlayerByPositions($lineup, $minute, $positionOrder);
    }

    /**
     * @param Lineup $attackingTeam
     * @param Lineup $defendingTeam
     * @param int $count
     * @return MatchEvent[]
     */
    protected function buildAttackStopEvents(
        Lineup $attackingTeam,
        Lineup $defendingTeam,
        int $count
    ): array {
        if ($count < 1) {
            return [];
        }

        return array_map(function () use ($attackingTeam, $defendingTeam) {
            $minute = MatchHelper::getRandomMinute();

            $data = [
                'attacking_team' => $attackingTeam->teamId,
                'defending_team' => $defendingTeam->teamId,
            ];

            return new MatchEvent(MatchEvent::TYPE_ATTACK_STOP, $minute, $data);
        }, range(1, $count));
    }

    protected function getShootCount(
        LineupStrength $attackingTeam,
        LineupStrength $defendingTeam,
        int $attackCount
    ): int {
        $atK = $attackingTeam->attack + $attackingTeam->midfield * 0.33;
        $dtK = $defendingTeam->defence * 2 + $defendingTeam->midfield * 0.33;

        $shootCount = round($atK / $dtK * $attackCount);

        return $shootCount > $attackCount ? $attackCount : $shootCount;
    }

    protected function getAttackCount(MatchSettings $settings): int
    {
        $attackCountRandomModifier = rand(
                100 - $settings->attackCountRandomModifier,
                100 + $settings->attackCountRandomModifier
            ) / 100;

        return ceil($settings->baseAttackCount * $attackCountRandomModifier);
    }

    /**
     * Modify lineup strength based on multiple factors
     *
     * @param Lineup $lineup
     * @param MatchSettings $settings
     */
    protected function modifyLineupStrength(Lineup $lineup, MatchSettings $settings)
    {
        // modify by coach
        if ($lineup->coach) {
            $this->modifyStrengthByCoach($lineup, $settings);
        }

        // apply tactic bonuses
        $this->applyTacticBonus($lineup);

        // apply pressure bonus
        if ($settings->withPressure) {
            $this->applyPressureBonus($lineup);
        }

        // todo apply bonus from passing style vs defensive line
    }

    /**
     * @param Lineup $lineup
     */
    protected function applyTacticBonus(Lineup $lineup)
    {
        $strength = $lineup->strength;
        $tactic = $lineup->tactic;

        $modifier = new FlatLineupStrengthModifier();
        switch ($tactic) {
            case Lineup::TACTIC_OFFENSIVE:
                $amount = $strength->defence * 0.8;
                $modifier->defenceModifier -= $amount;
                $modifier->attackModifier = $amount;
                break;
            case Lineup::TACTIC_DEFENSIVE:
                $amount = $strength->attack * 0.8;
                $modifier->attackModifier -= $amount;
                $modifier->defenceModifier += $amount;
                break;
            case Lineup::TACTIC_COUNTER_ATTACKS:
                $amount = $strength->defence * 0.8;
                $modifier->defenceModifier -= $amount;
                $modifier->midfieldModifier += $amount / 2;
                $modifier->attackModifier += $amount / 2;
                break;
            case Lineup::TACTIC_TOWARDS_MIDDLE:
                $defAmount = $strength->defence * 0.9;
                $attAmount = $strength->attack * 0.9;

                $modifier->defenceModifier -= $defAmount;
                $modifier->attackModifier -= $attAmount;
                $modifier->midfieldModifier = $defAmount + $attAmount;
                break;
            case Lineup::TACTIC_ATTACKERS_TOWARDS_MIDDLE:
                $amount = $strength->attack * 0.85;
                $modifier->attackModifier -= $amount;
                $modifier->midfieldModifier = $amount;
                break;
            case Lineup::TACTIC_DEFENDERS_TOWARDS_MIDDLE:
                $amount = $strength->defence * 0.85;
                $modifier->defenceModifier -= $amount;
                $modifier->midfieldModifier = $amount;
                break;
            case Lineup::TACTIC_PLAY_IT_WIDE:
                $amount = $strength->midfield * 0.8;
                $modifier->midfieldModifier -= $amount;
                $modifier->defenceModifier = $amount / 2;
                $modifier->attackModifier = $amount / 2;
                break;
        }

        $lineup->strength->applyModifier($modifier);
    }

    protected function applyPressureBonus(Lineup $lineup)
    {
        switch ($lineup->pressure) {
            case Lineup::PRESSURE_SOFT:
                $pressureK = 0.85;
                break;
            case Lineup::PRESSURE_HARD:
                $pressureK = 1.1;
                break;
            default:
                $pressureK = 1;
        }

        if ($pressureK !== 1) {
            $modifier = new RelativeLineupStrengthModifier();
            $modifier->defenceModifier = $pressureK;
            $modifier->midfieldModifier = $pressureK;
            $modifier->attackModifier = $pressureK;

            $lineup->strength->applyModifier($modifier);
        }
    }

    protected function applyHomeTeamBonus(Lineup $lineup, MatchSettings $settings)
    {
        $modifier = new RelativeLineupStrengthModifier();
        $modifier->defenceModifier = $settings->homeTeamBonus;
        $modifier->midfieldModifier = $settings->homeTeamBonus;
        $modifier->attackModifier = $settings->homeTeamBonus;

        $lineup->strength->applyModifier($modifier);
    }

    public function modifyStrengthByCoach(Lineup $lineup, MatchSettings $settings)
    {
        $coach = $lineup->coach;
        if (!$coach) {
            return;
        }
        $levelBonus = $settings->coachLevelBonus * $coach->level;

        $defenseModifier = $levelBonus;
        $midfieldModifier = $levelBonus;
        $attackModifier = $levelBonus;

        if ($coach->speciality == Coach::SPECIALITY_DEF) {
            $defenseModifier *= $settings->coachSpecialityBonus;
        } elseif ($coach->speciality == Coach::SPECIALITY_MID) {
            $midfieldModifier *= $settings->coachSpecialityBonus;
        } elseif ($coach->speciality == Coach::SPECIALITY_ATT) {
            $attackModifier *= $settings->coachSpecialityBonus;
        }

        $modifier = new FlatLineupStrengthModifier();
        $modifier->defenceModifier = $defenseModifier;
        $modifier->midfieldModifier = $midfieldModifier;
        $modifier->attackModifier = $attackModifier;

        $lineup->strength->applyModifier($modifier);
    }
}
