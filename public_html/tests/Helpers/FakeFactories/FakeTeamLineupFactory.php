<?php

declare(strict_types=1);

namespace Tests\Helpers\FakeFactories;

use Faker\Factory;
use OSM\Core\Models\TeamLineup;

/**
 * @method static TeamLineup create(array $data = [])
 */
class FakeTeamLineupFactory extends FakeModelFactory
{
    public static function modelClass(): string
    {
        return TeamLineup::class;
    }

    public static function fakeAttributes(): array
    {
        $faker = Factory::create();

        return [
            'id' => $faker->randomNumber(),
            'teamId' => $faker->randomNumber(),
            'name' => 'Fake',
            'passingStyle' => TeamLineup::PASSING_MIXED,
            'defensiveLine' => TeamLineup::DEFENSIVE_LINE_NORMAL,
            'tactic' => TeamLineup::TACTIC_NONE,
            'pressure' => TeamLineup::PRESSURE_NORMAL
        ];
    }
}