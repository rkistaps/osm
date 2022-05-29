<?php

declare(strict_types=1);

namespace Tests\Helpers\FakeFactories;

use Faker\Factory;
use OSM\Core\Models\Player;

/**
 * @method public static create(array $data)
 */
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
            'id' => $faker->unique()->randomNumber(),
            'name' => $faker->name,
            'surname' => $faker->lastName,
        ];
    }

    public static function createForPosition(string $position): Player
    {
        return FakePlayerFactory::create(['position' => $position]);
    }
}