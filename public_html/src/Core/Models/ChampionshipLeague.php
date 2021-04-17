<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class ChampionshipLeague extends AbstractModel
{
    public int $championshipId;
    public string $name;
    public int $level = 1;
    public int $hardness = 0;
}
