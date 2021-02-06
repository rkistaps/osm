<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Match;

class MatchCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Match::class;
    }
}
