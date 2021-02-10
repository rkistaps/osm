<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Common\Structures;

use OSM\Core\Collections\TeamCollection;
use OSM\Core\Helpers\Traits\FromArrayTrait;

class TableCreationParameters
{
    use FromArrayTrait;

    public int $championshipId;
    public TeamCollection $teams;
    public bool $writeFixtures = true;
}
