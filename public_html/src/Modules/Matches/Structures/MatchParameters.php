<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Structures;

use OSM\Modules\MatchEngine\Structures\MatchSettings;

class MatchParameters
{
    /**
     * Settings used in MatchEngine
     * @var MatchSettings
     */
    public MatchSettings $matchSettings;

    /**
     * Do not save anything after game
     * @var bool
     */
    public bool $dryRun = false;

    /**
     * How many experience points players receive
     * @var int
     */
    public int $experienceGain = 3;

    /**
     * Should remove energy after game
     * @var bool
     */
    public bool $processFatigue = true;

    /**
     * Should save injuries after game
     * @var bool
     */
    public bool $processInjuries = true;

    /**
     * Should save player stats after game
     * @var bool
     */
    public bool $processPlayerStats = true;

    /**
     * Ignore players energy level and use 100%
     * @var bool
     */
    public bool $useFullEnergy = false;

    /**
     * MatchParams constructor.
     * @param MatchSettings $matchSettings
     */
    public function __construct(MatchSettings $matchSettings)
    {
        $this->matchSettings = $matchSettings;
    }
}
