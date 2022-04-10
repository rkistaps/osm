<?php

declare(strict_types=1);

namespace OSM\Core\Helpers;

use Jawira\CaseConverter\Convert;

class StringHelper
{
    public static function toSnakeCase(string $string): string
    {
        return (new Convert($string))->toSnake();
    }

    public static function toCamelCase(string $string): string
    {
        return (new Convert($string))->toCamel();
    }

    public static function toPascal(string $string): string
    {
        return (new Convert($string))->toPascal();
    }

    public static function getRomanNumerals(int $n): string
    {
        $res = '';
        $roman_numerals = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        foreach ($roman_numerals as $roman => $number) {
            $matches = intval($n / $number);
            $res .= str_repeat($roman, $matches);
            $n = $n % $number;
        }

        return $res;
    }
}
