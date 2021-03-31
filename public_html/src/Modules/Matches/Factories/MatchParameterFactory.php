<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Factories;

use OSM\Core\Models\Match;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\Matches\Structures\MatchParameters;

class MatchParameterFactory
{
    private MatchSettingFactory $settingFactory;

    public function __construct(
        MatchSettingFactory $settingFactory
    ) {
        $this->settingFactory = $settingFactory;
    }

    public function buildForFriendlies(MatchSettings $settings = null): MatchParameters
    {
        return $this->buildDefault($settings)
            ->setProcessInjuries(false)
            ->setProcessFatigue(false)
            ->setProcessPlayerStats(false)
            ->setUseFullEnergy(true);
    }

    public function buildDefault(MatchSettings $settings = null): MatchParameters
    {
        $settings = $settings ?? $this->settingFactory->buildDefault();

        return new MatchParameters($settings);
    }

    public function buildForMatch(Match $match): MatchParameters
    {
        if ($match->isFriendly()) {
            return $this->buildForFriendlies();
        }

        // todo implement
        return $this->buildDefault();
    }
}
