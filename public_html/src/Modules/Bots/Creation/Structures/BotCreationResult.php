<?php

declare(strict_types=1);

namespace OSM\Modules\Bots\Creation\Structures;

use OSM\Core\Models\Team;
use OSM\Core\Models\User;

class BotCreationResult
{
    public User $user;
    public Team $team;
}
