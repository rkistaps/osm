<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class Coach
 * @package OSM\Modules\MatchEngine\Structures
 */
class Coach
{
    const SPECIALITY_NON = 'none';
    const SPECIALITY_DEF = 'defence';
    const SPECIALITY_MID = 'midfield';
    const SPECIALITY_ATT = 'attack';

    const SPECIALITIES = [
        Coach::SPECIALITY_NON,
        Coach::SPECIALITY_DEF,
        Coach::SPECIALITY_MID,
        Coach::SPECIALITY_ATT,
    ];

    public string $speciality = self::SPECIALITY_NON;
    public int $level = 1;
}
