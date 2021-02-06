<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Factories;

use OSM\Modules\MatchEngine\Structures\MatchSettings;

class MatchSettingFactory
{
    public function buildDefault(): MatchSettings
    {
        return new MatchSettings();
    }
}
