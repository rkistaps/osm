<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Teams\Models;

use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\Country;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;

class TeamViewModel
{
    public Team $team;
    public User $user;
    public Country $country;
    public ?ChampionshipLeague $league = null;

}
