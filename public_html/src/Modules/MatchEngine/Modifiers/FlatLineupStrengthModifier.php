<?php

namespace OSM\Modules\MatchEngine\Modifiers;

use OSM\Modules\MatchEngine\Interfaces\LineupStrengthModifierInterface;
use OSM\Modules\MatchEngine\Structures\LineupStrength;

/**
 * Class FlatLineupStrengthModifier
 * @package OSM\Modules\MatchEngine\modifiers
 */
class FlatLineupStrengthModifier implements LineupStrengthModifierInterface
{
    public float $goalkeeperModifier = 0;
    public float $defenceModifier = 0;
    public float $midfieldModifier = 0;
    public float $attackModifier = 0;

    /**
     * Apply modifier to strength
     * @param LineupStrength $strength
     */
    public function apply(LineupStrength $strength)
    {
        $strength->goalkeeper += $this->goalkeeperModifier;
        $strength->defence += $this->defenceModifier;
        $strength->midfield += $this->midfieldModifier;
        $strength->attack += $this->attackModifier;
    }
}
