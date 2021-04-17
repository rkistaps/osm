<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Match;

/**
 * @method Match[] all()
 */
class MatchCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Match::class;
    }

    /**
     * @return int[]
     */
    public function getTeamIds(): array
    {
        return $this->reduce(function (array $carry, Match $match) {
            $carry[] = $match->homeTeamId;
            $carry[] = $match->awayTeamId;

            return $carry;
        }, []);
    }
}
