<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\LineupStrength;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\MatchEngine\Structures\Player;

/**
 * Class LineupStrengthCalculatorService
 * @package OSM\Modules\MatchEngine\services
 */
class LineupStrengthCalculatorService
{
    /**
     * @param Lineup $lineup
     * @param MatchSettings $settings
     * @return LineupStrength
     */
    public function calculate(Lineup $lineup, MatchSettings $settings): LineupStrength
    {
        $strength = new LineupStrength();
        $strength->goalkeeper = $this->positionStrength(Player::POS_G, $lineup, $settings);
        $strength->defence = $this->positionStrength(Player::POS_D, $lineup, $settings);
        $strength->midfield = $this->positionStrength(Player::POS_M, $lineup, $settings);
        $strength->attack = $this->positionStrength(Player::POS_F, $lineup, $settings);

        return $strength;
    }

    /**
     * @param string $position
     * @param Lineup $lineup
     * @param MatchSettings $settings
     * @return float
     */
    protected function positionStrength(string $position, Lineup $lineup, MatchSettings $settings): float
    {
        switch ($position) {
            case Player::POS_D:
                $positionK = $settings->defenseModifier;
                break;
            case Player::POS_M:
                $positionK = $settings->midfieldModifier;
                break;
            case Player::POS_F:
                $positionK = $settings->attackModifier;
                break;
            default:
                $positionK = 1;
        }

        $pressureK = 1;
        if ($settings->withPressure) {
            switch ($lineup->pressure) {
                case Lineup::PRESSURE_SOFT:
                    $pressureK = 0.85;
                    break;
                case Lineup::PRESSURE_HARD:
                    $pressureK = 1.1;
                    break;
            }
        }

        $sum = collect($lineup->players)
            ->filter(function (Player $player) use ($position) {
                return $player->isInPosition($position);
            })
            ->sum(function (Player $player) {
                return $player->getImpact();
            });

        return round($sum / $positionK * $pressureK);
    }
}
