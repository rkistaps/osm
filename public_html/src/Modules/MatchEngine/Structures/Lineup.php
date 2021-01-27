<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class Lineup
 * @package OSM\Modules\MatchEngine\Structures
 */
class Lineup
{
    // pressures
    const PRESSURE_SOFT = 'soft';
    const PRESSURE_NORMAL = 'normal';
    const PRESSURE_HARD = 'hard';

    // tactics
    const TACTIC_NONE = 'none';
    const TACTIC_OFFENSIVE = 'offensive';
    const TACTIC_DEFENSIVE = 'defensive';
    const TACTIC_COUNTER_ATTACKS = 'counter-attacks';
    const TACTIC_TOWARDS_MIDDLE = 'towards-middle';
    const TACTIC_ATTACKERS_TOWARDS_MIDDLE = 'attackers-towards-middle';
    const TACTIC_DEFENDERS_TOWARDS_MIDDLE = 'defenders-towards-middle';
    const TACTIC_MIDFIELDERS_TOWARDS_DEFENSE = 'midfielders-towards-defense';
    const TACTIC_MIDFIELDERS_TOWARDS_ATTACK = 'midfielders-towards-attack';
    const TACTIC_PLAY_IT_WIDE = 'play-it-wide';

    // passing styles
    const PASSING_SHORT = 'short';
    const PASSING_LONG = 'long';
    const PASSING_MIXED = 'mixed';

    // defensive lines
    const DEFENSIVE_LINE_LOW = 'low';
    const DEFENSIVE_LINE_HIGH = 'high';
    const DEFENSIVE_LINE_NORMAL = 'normal';

    public int $teamId;
    public ?Coach $coach;
    public string $tactic;
    public string $passingStyle;
    public string $defensiveLine;
    public string $pressure;
    public LineupStrength $strength;

    /** @var Player[] */
    public array $players = [];

    public function isPassingStyle(string $passingStyle): bool
    {
        return $this->passingStyle === $passingStyle;
    }

    public function isDefensiveLine(string $defensiveLine): bool
    {
        return $this->defensiveLine === $defensiveLine;
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
