<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Modules\MatchEngine\Structures\LineupStrength;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\MatchEngine\Structures\Possession;

/**
 * Class PossessionCalculatorService
 * @package OSM\Modules\MatchEngine\services
 */
class PossessionCalculatorService
{
    public function calculate(LineupStrength $homeTeam, LineupStrength $awayTeam, MatchSettings $settings): Possession
    {
        $homeTeamMidStrength = $homeTeam->midfield;
        $awayTeamMidStrength = $awayTeam->midfield;

        $homeTeamK = $homeTeamMidStrength * 2 / $awayTeamMidStrength;
        $awayTeamK = $awayTeamMidStrength * 2 / $homeTeamMidStrength;

        $from = 100 - $settings->possessionRandomRange;
        $to = 100 + $settings->possessionRandomRange;

        $randomModifier = rand($from, $to) / 100;

        $homeTeamPossession = $homeTeamK / ($homeTeamK + $awayTeamK) * $randomModifier;
        $homeTeamPossession = $homeTeamPossession < 0.99 ? $homeTeamPossession : 0.99;

        $awayTeamPossession = 1 - $homeTeamPossession;

        $possession = new Possession();
        $possession->homeTeam = $homeTeamPossession;
        $possession->awayTeam = $awayTeamPossession;

        return $possession;
    }
}
