<?php

declare(strict_types=1);

namespace Tests\Helpers\FakeFactories;

use OSM\Core\Collections\TeamLineupPlayerCollection;

class FakeTeamLineupPlayerCollectionFactory
{
    public static function createForLineupId(int $lineupId, int $count = 11): TeamLineupPlayerCollection
    {
        $collection = new TeamLineupPlayerCollection();

        for ($i = 0; $i != $count; $i++) {
            $collection->add(FakeTeamLineupPlayerFactory::create(['teamLineupId' => $lineupId]));
        }

        return $collection;
    }
}