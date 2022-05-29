<?php

declare(strict_types=1);

namespace Tests\Helpers;

use Faker\Factory;
use Faker\Generator;

final class FakerFactory
{
    private static ?Generator $instance = null;

    public static function getFaker(): Generator
    {
        if (!self::$instance) {
            self::$instance = Factory::create();
        }

        return self::$instance;
    }
}
