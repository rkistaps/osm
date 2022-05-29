<?php

declare(strict_types=1);

namespace Tests\Helpers\FakeFactories;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\Player;

class FakePlayerCollectionFactory
{
    public static function createForLineup(): PlayerCollection
    {
        $collection = new PlayerCollection();

        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_G));

        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_D));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_D));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_D));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_D));

        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_M));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_M));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_M));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_M));

        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_F));
        $collection->add(FakePlayerFactory::createForPosition(Player::POSITION_F));

        return $collection;
    }
}