<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class ShootResult
 * @package OSM\Modules\MatchEngine\Structures
 */
class ShootResult
{
    public const RESULT_GOAL = 'goal';
    public const RESULT_SAVE = 'save';

    private ShootConfig $shootConfig;
    private string $result;

    public function __construct(string $result, ShootConfig $config)
    {
        $this->shootConfig = $config;
        $this->result = $result;
    }

    public function getShootConfig(): ShootConfig
    {
        return $this->shootConfig;
    }

    public function isGoal(): bool
    {
        return $this->result == ShootResult::RESULT_GOAL;
    }
}
