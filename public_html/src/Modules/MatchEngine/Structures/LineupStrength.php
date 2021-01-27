<?php

namespace OSM\Modules\MatchEngine\Structures;

use OSM\Modules\MatchEngine\Interfaces\LineupStrengthModifierInterface;

/**
 * Class LineupStrength
 * @package OSM\Modules\MatchEngine\Structures
 */
class LineupStrength
{
    public float $goalkeeper = 0;
    public float $defence = 0;
    public float $midfield = 0;
    public float $attack = 0;

    /**
     * Apply modifier
     * @param LineupStrengthModifierInterface $modifier
     */
    public function applyModifier(LineupStrengthModifierInterface $modifier)
    {
        $modifier->apply($this);
    }
}
