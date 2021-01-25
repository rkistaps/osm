<?php

declare(strict_types=1);

namespace OSM\Core\Helpers;

use Jawira\CaseConverter\Convert;

class StringHelper
{
    public static function toSnakeCase(string $string): string
    {
        $text = new Convert($string);

        return $text->toSnake();
    }

    public static function toCamelCase(string $string): string
    {
        $text = new Convert($string);

        return $text->toCamel();
    }
}
