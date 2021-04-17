<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Structures;

class LeagueCreationParameters
{
    public int $championshipId;
    public ?string $name = '';
    public int $number = 1;
    public int $level = 1;
    public bool $addTeams = false;
    public bool $createTable = false;
}
