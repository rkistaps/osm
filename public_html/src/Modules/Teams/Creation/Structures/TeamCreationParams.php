<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Creation\Structures;

use OSM\Core\Helpers\Traits\FromArrayTrait;

class TeamCreationParams
{
    use FromArrayTrait;

    public int $userId;
    public int $countryId;
    public string $name;
    public bool $isDefault = false;
}
