<?php

declare(strict_types=1);

namespace Tests\Helpers\FakeFactories;

use Faker\Factory;
use OSM\Core\Models\Player;

class FakePlayerFactory extends FakeModelFactory
{
    /**
     * @inheritDoc
     */
    public static function modelClass(): string
    {
        return Player::class;
    }

    public static function fakeAttributes(): array
    {
        $faker = Factory::create();

        return [
            'name' => $faker->name,
            'surname' => $faker->lastName,
        ];
    }
}