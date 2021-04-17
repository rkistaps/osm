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
     * @param int|float $min
     * @param int|float $max
     * @return float
     */
    public static function between($min, $max)
    {
        $isInt = is_int($min) && is_int($max);

        $min = (int)round($min * 100);
        $max = (int)round($max * 100);

        $result = rand($min, $max) / 100;

        return $isInt ? (int)$result : $result;
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
