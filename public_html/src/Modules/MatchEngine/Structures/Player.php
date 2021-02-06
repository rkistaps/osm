<?php

namespace OSM\Modules\MatchEngine\Structures;

use OSM\Modules\MatchEngine\Helpers\MatchHelper;

/**
 * Class Player
 * @package OSM\Modules\MatchEngine\Structures
 */
class Player
{
    public const POS_G = 'G';
    public const POS_D = 'D';
    public const POS_M = 'M';
    public const POS_F = 'F';

    public const STATUS_STARTING = 'starting';
    public const STATUS_SUBSTITUTE = 'substitute';
    public const STATUS_SENT_OFF = 'sent-off';

    public int $id;
    public int $age;
    public string $position;
    public string $speciality;
    public int $skill = 0;
    public int $experience = 0;
    public int $energy = 100;
    public PlayerStatistics $statistics;
    public PlayerPerformance $performance;
    public ?Injury $injury = null;

    /** @var Penalty[] */
    public array $penalties = [];

    /**
     * On field, substitute, injured
     * @var string
     */
    public string $status;

    /**
     * Player constructor.
     */
    public function __construct()
    {
        $this->statistics = new PlayerStatistics();
        $this->performance = new PlayerPerformance();
    }

    /**
     * Get players performance. If $min given, check if player was injured and adjust $performance accordingly
     * @param int $min
     * @return int
     */
    public function getPerformance($min = null): int
    {
        $performance = $this->performance->performance;

        // if we are checking performance for specific minute and player has injury after that point
        // adjust performance accordingly
        if ($min && $this->injury && $min > $this->injury->minute) {
            $performance = round($performance / 2);
        }

        return $performance;
    }

    /**
     * Get players impact on whole game
     */
    public function getImpact(): float
    {
        $impact = $this->performance->getImpact();

        // if player was injured at some point, but played whole game, take that into account
        if ($this->injury && $this->performance->getParticipation() === 1) {
            $injuryPenalty = 0.5;

            $injuredPart = (MatchHelper::MATCH_LENGTH - $this->injury->minute) / MatchHelper::MATCH_LENGTH;
            $injuredImpact = $injuredPart * $impact * $injuryPenalty;

            $healthyPart = (1 - $injuredPart);
            $healthyImpact = $healthyPart * $impact;

            return round($injuredImpact + $healthyImpact);
        }

        return round($impact);
    }

    /**
     * @return bool
     */
    public function isGoalkeeper(): bool
    {
        return $this->position === self::POS_G;
    }

    /**
     * Check if player is in given position
     * @param string $position
     * @return bool
     */
    public function isInPosition(string $position): bool
    {
        return $this->position === $position;
    }

    /**
     * Was player injured at some point
     * @return bool
     */
    public function isInjured(): bool
    {
        return !!$this->injury;
    }

    /**
     * Was player sent off at some point
     * @return bool
     */
    public function isSentOff(): bool
    {
        return $this->status === self::STATUS_SENT_OFF;
    }

    /**
     * Is on field
     * @return bool
     */
    public function isStarting(): bool
    {
        return $this->status === self::STATUS_STARTING;
    }

    /**
     * @param int $minute
     * @return bool
     */
    public function wasOnField(int $minute): bool
    {
        return $this->performance->playedFromMin <= $minute && $this->performance->playedToMin >= $minute;
    }

    /**
     * @return Penalty|null
     */
    public function getYellowCard(): ?Penalty
    {
        return collect($this->penalties)
            ->first(function (Penalty $penalty) {
                return $penalty->type === Penalty::TYPE_YELLOW_CARD;
            });
    }
}