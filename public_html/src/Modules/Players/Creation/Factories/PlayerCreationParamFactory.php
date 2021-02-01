<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Factories;

use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Models\Country;
use OSM\Core\Models\Team;
use OSM\Modules\Players\Creation\Structures\PlayerCreationParams;

class PlayerCreationParamFactory
{
    public function forStartingPlayer(Team $team, Country $country): PlayerCreationParams
    {
        $params = $this->forTeam($team, $country);

        $params->talent = RandomHelper::between(0, 5);
        $params->age = RandomHelper::between(23, 27);
        $params->skill = RandomHelper::between(125, 175);

        return $params;
    }

    public function forTeam(Team $team, Country $country): PlayerCreationParams
    {
        $params = new PlayerCreationParams();
        $params->team = $team;
        $params->country = $country;

        return $params;
    }
}
