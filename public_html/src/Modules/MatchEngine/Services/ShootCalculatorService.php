<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Modules\MatchEngine\Structures\ShootConfig;
use OSM\Modules\MatchEngine\Structures\ShootResult;

/**
 * Class ShootCalculatorService
 * @package OSM\Modules\MatchEngine\services
 */
class ShootCalculatorService
{
    public function shoot(ShootConfig $shootConfig): ShootResult
    {
        $strikerPref = $shootConfig->striker->getPerformance($shootConfig->minute);
        $goalkeeperPref = $shootConfig->goalkeeper->getPerformance($shootConfig->minute);

        $attackHelperPref = $shootConfig->attackHelper ? $shootConfig->attackHelper->getPerformance($shootConfig->minute) : 0;
        $defenseHelperPref = $shootConfig->defenseHelper ? $shootConfig->defenseHelper->getPerformance($shootConfig->minute) : 0;

        $goalK = round($strikerPref * $strikerPref / ($strikerPref * $strikerPref + $goalkeeperPref * $goalkeeperPref), 2);

        $helperBonus = 0;
        if ($shootConfig->attackHelper && $shootConfig->defenseHelper) { // both helpers
            $helperBonus = round(($attackHelperPref / ($attackHelperPref + $defenseHelperPref) - 0.5), 2);
        } elseif ($shootConfig->attackHelper && !$shootConfig->defenseHelper) {
            $helperBonus = round($attackHelperPref / ($goalkeeperPref * 2.5), 2);
        } elseif (!$shootConfig->attackHelper && $shootConfig->defenseHelper) {
            $helperBonus = round($defenseHelperPref / ($strikerPref * 2.5), 2);
        }

        $goalK += $helperBonus;
        $saveK = round(0.5 + rand($shootConfig->randomModifier * (-1), $shootConfig->randomModifier) / 100, 2);

        $saveBonusK = $shootConfig->saveBonus * 0.05;

        $goal = $goalK > $saveK + $saveBonusK;
        $resultType = $goal ? ShootResult::RESULT_GOAL : ShootResult::RESULT_SAVE;

        return new ShootResult($resultType, $shootConfig);
    }
}
