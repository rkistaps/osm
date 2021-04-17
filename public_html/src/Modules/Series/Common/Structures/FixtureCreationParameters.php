<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Common\Structures;

use OSM\Core\Collections\TeamCollection;

class FixtureCreationParameters
{
    public int $championshipId;
    public TeamCollection $teams;
    public int $rounds = 2;
}
