<?php

namespace OSM\Modules\MatchEngine\Modifiers;

use OSM\Modules\MatchEngine\Interfaces\LineupStrengthModifierInterface;
use OSM\Modules\MatchEngine\Structures\LineupStrength;

/**
 * Class FlatLineupStrengthModifier
 * @package OSM\Modules\MatchEngine\modifiers
 */
class RelativeLineupStrengthModifier implements LineupStrengthModifierInterface
{
    public float $goalkeeperModifier = 1;
    public float $defenceModifier = 1;
    public float $midfieldModifier = 1;
    public float $attackModifier = 1;

    /**
     * Apply modifier to strength
     * @param LineupStrength $strength
     */
    public function apply(LineupStrength $strength)
    {
        $strength->goalkeeper *= $this->goalkeeperModifier;
        $strength->defence *= $this->defenceModifier;
        $strength->midfield *= $this->midfieldModifier;
        $strength->attack *= $this->attackModifier;
    }
}
