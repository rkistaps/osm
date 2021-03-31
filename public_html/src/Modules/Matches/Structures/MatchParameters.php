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
    public bool $isDryRun = false;

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
     * @param MatchSettings $matchSettings
     * @return MatchParameters
     */
    public function setMatchSettings(MatchSettings $matchSettings): MatchParameters
    {
        $this->matchSettings = $matchSettings;
        return $this;
    }

    /**
     * @param bool $isDryRun
     * @return MatchParameters
     */
    public function setIsDryRun(bool $isDryRun): MatchParameters
    {
        $this->isDryRun = $isDryRun;
        return $this;
    }

    /**
     * @param int $experienceGain
     * @return MatchParameters
     */
    public function setExperienceGain(int $experienceGain): MatchParameters
    {
        $this->experienceGain = $experienceGain;
        return $this;
    }

    /**
     * @param bool $processFatigue
     * @return MatchParameters
     */
    public function setProcessFatigue(bool $processFatigue): MatchParameters
    {
        $this->processFatigue = $processFatigue;
        return $this;
    }

    /**
     * @param bool $processInjuries
     * @return MatchParameters
     */
    public function setProcessInjuries(bool $processInjuries): MatchParameters
    {
        $this->processInjuries = $processInjuries;
        return $this;
    }

    /**
     * @param bool $processPlayerStats
     * @return MatchParameters
     */
    public function setProcessPlayerStats(bool $processPlayerStats): MatchParameters
    {
        $this->processPlayerStats = $processPlayerStats;
        return $this;
    }

    /**
     * @param bool $useFullEnergy
     * @return MatchParameters
     */
    public function setUseFullEnergy(bool $useFullEnergy): MatchParameters
    {
        $this->useFullEnergy = $useFullEnergy;
        return $this;
    }

    /**
     * MatchParams constructor.
     * @param MatchSettings $matchSettings
     */
    public function __construct(MatchSettings $matchSettings)
    {
        $this->matchSettings = $matchSettings;
    }
}
