<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Player extends AbstractModel
{
    // positions
    public const POSITION_G = 'G';
    public const POSITION_D = 'D';
    public const POSITION_M = 'M';
    public const POSITION_F = 'F';

    // characters - off field
    public const CHARACTER_NONE = 'none';
    public const CHARACTER_HARD_WORKING = 'hard_working';
    public const CHARACTER_LAZY_WORKING = 'lazy_working';

    // specialities - on field
    public const SPECIALITY_NONE = 'none';
    public const SPECIALITY_SHOOTING = 'shooting';
    public const SPECIALITY_PASSING = 'passing';
    public const SPECIALITY_TACKLING = 'tackling';
    public const SPECIALITY_WEAK = 'weak';
    public const SPECIALITY_IRONMAN = 'ironman';

    public const AVAILABLE_CHARACTERS = [
        self::CHARACTER_NONE,
        self::CHARACTER_HARD_WORKING,
        self::CHARACTER_LAZY_WORKING,
        self::SPECIALITY_IRONMAN,
        self::SPECIALITY_WEAK,
    ];

    public const AVAILABLE_SPECIALITIES = [
        self::SPECIALITY_NONE,
        self::SPECIALITY_PASSING,
        self::SPECIALITY_SHOOTING,
        self::SPECIALITY_TACKLING,
    ];

    public string $name;
    public string $surname;
    public int $age;
    public float $skill;
    public int $talent;
    public int $energy = 100;
    public int $injuryDays = 0;
    public int $countryId;
    public int $teamId;
    public string $position;
    public int $experience = 0;
    public string $speciality = self::SPECIALITY_NONE;
    public string $character = self::CHARACTER_NONE;
    public float $salary = 0;
    public int $number = 0;
    public bool $isYouth = false;
}
