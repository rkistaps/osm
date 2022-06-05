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

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public static function getAvailableSpecialities(): array
    {
        return [
            self::SPECIALITY_NONE => _f('None'),
            self::SPECIALITY_PASSING => _f('Passing'),
            self::SPECIALITY_SHOOTING => _f('Shooting'),
            self::SPECIALITY_TACKLING => _f('Tackling'),
            self::SPECIALITY_IRONMAN => _f('Ironman'),
            self::SPECIALITY_WEAK => _f('Weak'),
         ];
    }

    public function getSpecialityLabel(): string
    {
        return self::getAvailableSpecialities()[$this->speciality] ?? _f('None');
    }

    public static function getAvailableCharacters(): array
    {
        return [
            self::CHARACTER_NONE => _f('None'),
            self::CHARACTER_HARD_WORKING => _f('Hard working'),
            self::CHARACTER_LAZY_WORKING => _f('Lazy working'),
        ];
    }

    public static function getAvailablePositions(): array
    {
        return [
            self::POSITION_G => _f('Goalkeeper'),
            self::POSITION_D => _f('Defender'),
            self::POSITION_M => _f('Midfielder'),
            self::POSITION_F => _f('Forward'),
        ];
    }

    public function getPositionLabel(): string
    {
        return self::getAvailablePositions()[$this->position];
    }

    public function getCharacterLabel():string
    {
        return self::getAvailableCharacters()[$this->character] ?? _f('None');
    }

    public function isGoalkeeper(): bool
    {
        return $this->isPosition(self::POSITION_G);
    }

    public function isDefender(): bool
    {
        return $this->isPosition(self::POSITION_D);
    }

    public function isMidfielder(): bool
    {
        return $this->isPosition(self::POSITION_M);
    }

    public function isForward(): bool
    {
        return $this->isPosition(self::POSITION_F);
    }

    public function isPosition(string $position): bool
    {
        return $this->position === $position;
    }

    public function isInjured(): bool
    {
        return $this->injuryDays > 0;
    }
}
