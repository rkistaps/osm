<?php

declare(strict_types=1);

namespace OSM\Core\Helpers;

class NumberHelper
{
    public static function isBetween(float $number, float $start, float $end, bool $including = true): bool
    {
        return self::isBigger($number, $start, $including) && self::isSmaller($number, $end, $including);
    }

    public static function isNotBetween(float $number, float $start, float $end, bool $including = true): bool
    {
        return !self::isBetween($number, $start, $end, $including);
    }

    public static function isBigger(float $number, float $than, bool $including = true): bool
    {
        return $including ?
            $number >= $than :
            $number > $than;
    }

    public static function isSmaller(float $number, float $than, bool $including = true): bool
    {
        return $including ?
            $number <= $than :
            $number < $than;
    }

    public static function formatMoney(float $money, int $dec = 2): string
    {
        return "€ " . number_format($money, $dec);
    }
}
