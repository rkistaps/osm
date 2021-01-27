<?php

namespace OSM\Modules\MatchEngine\Interfaces;

use OSM\Modules\MatchEngine\Structures\LineupStrength;

/**
 * Class LineupStrengthModifierInterface
 * @package OSM\Modules\MatchEngine\Interfaces
 */
interface LineupStrengthModifierInterface
{
    /**
     * Apply lineup strength modifier
     * @param LineupStrength $strength
     */
    public function apply(LineupStrength $strength);
}