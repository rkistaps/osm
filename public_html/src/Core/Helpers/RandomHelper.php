<?php

declare(strict_types=1);

namespace OSM\Core\Helpers;

class RandomHelper
{
    /**
     * @param int $percentage
     * @return bool
     */
    public static function chance(int $percentage): bool
    {
        return rand(1, 100) <= $percentage;
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function between(int $min, int $max): int
    {
        return rand($min, $max);
    }

    /**
     * Get one item by given chances
     * $array format:
     * [
     *  10 => '10%', // 10% option
     *  30 => '30%', // 30% option
     *  20 => '20%', // 20% option
     *  40 => '40%', // 40% option
     * ]
     * @param array $array
     * @return mixed|null
     */
    public static function getOneByChance(array $array)
    {
        $rand = rand(1, 100);
        ksort($array);
        $counter = 0;
        foreach ($array as $chance => $value) {
            if ($chance + $counter >= $rand) {
                return $value;
            }

            $counter += $chance;
        }

        return null;
    }
}
