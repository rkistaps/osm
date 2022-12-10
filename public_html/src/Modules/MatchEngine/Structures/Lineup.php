<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class Lineup
 * @package OSM\Modules\MatchEngine\Structures
 */
class Lineup
{
    // pressures
    public const PRESSURE_SOFT = 'soft';
    public const PRESSURE_NORMAL = 'normal';
    public const PRESSURE_HARD = 'hard';

    // tactics
    public const TACTIC_NONE = 'none';
    public const TACTIC_OFFENSIVE = 'offensive';
    public const TACTIC_DEFENSIVE = 'defensive';
    public const TACTIC_COUNTER_ATTACKS = 'counter-attacks';
    public const TACTIC_TOWARDS_MIDDLE = 'towards-middle';
    public const TACTIC_ATTACKERS_TOWARDS_MIDDLE = 'attackers-towards-middle';
    public const TACTIC_DEFENDERS_TOWARDS_MIDDLE = 'defenders-towards-middle';
    public const TACTIC_MIDFIELDERS_TOWARDS_DEFENSE = 'midfielders-towards-defense';
    public const TACTIC_MIDFIELDERS_TOWARDS_ATTACK = 'midfielders-towards-attack';
    public const TACTIC_PLAY_IT_WIDE = 'play-it-wide';

    // passing styles
    public const PASSING_SHORT = 'short';
    public const PASSING_LONG = 'long';
    public const PASSING_MIXED = 'mixed';

    // defensive lines
    public const DEFENSIVE_LINE_LOW = 'low';
    public const DEFENSIVE_LINE_HIGH = 'high';
    public const DEFENSIVE_LINE_NORMAL = 'normal';

    public int $teamId;
    public ?Coach $coach;
    public string $tactic = self::TACTIC_NONE;
    public string $passingStyle = self::PASSING_MIXED;
    public string $defensiveLine = self::DEFENSIVE_LINE_NORMAL;
    public string $pressure = self::PRESSURE_NORMAL;
    public LineupStrength $strength;

    /** @var Player[] */
    public array $players = [];

    public function isPassingStyle(string $passingStyle): bool
    {
        return $this->passingStyle === $passingStyle;
    }

    public function isPassingLong(): bool
    {
        return $this->isPassingStyle(self::PASSING_LONG);
    }

    public function isPassingShort(): bool
    {
        return $this->isPassingStyle(self::PASSING_SHORT);
    }

    public function isPassingMixed():bool
    {
        $this->isPassingStyle = $this->isPassingStyle(self::PASSING_MIXED);
        return $this->isPassingStyle;
    }

    public function isDefensiveLine(string $defensiveLine): bool
    {
        return $this->defensiveLine === $defensiveLine;
    }

    public function isDefensiveLineLow(): bool
    {
        return $this->defensiveLine === self::DEFENSIVE_LINE_LOW;
    }

    public function isDefensiveLineHigh(): bool
    {
        return $this->defensiveLine === self::DEFENSIVE_LINE_HIGH;
    }

    public function isDefensiveLineNormal(): bool
    {
        return $this->defensiveLine === self::DEFENSIVE_LINE_NORMAL;
    }

    /**
     * @param string $status
     * @return Player[]
     */
    protected function getPlayersByStatus(string $status): array
    {
        return collect($this->players)
            ->filter(function (Player $player) use ($status) {
                return $player->status === $status;
            })
            ->all();
    }

    /**
     * Get starting players
     * @return Player[]
     */
    public function getStartingPlayers(): array
    {
        return $this->getPlayersByStatus(Player::STATUS_STARTING);
    }

    /**
     * Get substitute players
     * @return Player[]
     */
    public function getSubstitutes(): array
    {
        return $this->getPlayersByStatus(Player::STATUS_SUBSTITUTE);
    }
}
