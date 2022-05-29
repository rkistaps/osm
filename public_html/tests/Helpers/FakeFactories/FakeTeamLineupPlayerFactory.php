<?php

declare(strict_types=1);

namespace Tests\Helpers\FakeFactories;

use OSM\Core\Models\TeamLineupPlayer;
use Tests\Helpers\FakerFactory;

class FakeTeamLineupPlayerFactory extends FakeModelFactory
{
    public static function modelClass(): string
    {
        return TeamLineupPlayer::class;
    }

    public static function fakeAttributes(): array
    {
        $faker = FakerFactory::getFaker();

        return [
            'teamLineupId' => $faker->randomNumber(),
            'playerId' => $faker->unique()->randomNumber(),
        ];
    }
}