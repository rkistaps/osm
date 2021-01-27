<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class MatchEvent
 * @package OSM\Modules\MatchEngine\Structures
 */
class MatchEvent
{
    const TYPE_GOAL = 'goal';
    const TYPE_SAVE = 'save';
    const TYPE_ATTACK_STOP = 'attack_stop';
    const TYPE_YELLOW_CARD = 'yellow_card';
    const TYPE_RED_CARD = 'red_card';
    const TYPE_SECOND_YELLOW_CARD = 'second_yellow_card';
    const TYPE_INJURY_WITH_SUB = 'injury_with_sub';
    const TYPE_INJURY = 'injury';

    private int $minute;
    private string $type;
    private array $data = [];

    /**
     * Event constructor.
     *
     * @param string $type
     * @param int $minute
     * @param array $data
     */
    public function __construct(string $type, int $minute, array $data = [])
    {
        $this->type = $type;
        $this->minute = $minute;
        $this->data = $data;
    }

    /**
     * Get event type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get event minute
     * @return int
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    public function isGoal(): bool
    {
        return $this->type === self::TYPE_GOAL;
    }

    public function isType(string $type): bool
    {
        return $this->type === $type;
    }

    /**
     * Build Event from ShootResult
     *
     * @param ShootResult $result
     * @return MatchEvent
     */
    public static function fromShootResult(ShootResult $result): MatchEvent
    {
        $shootConfig = $result->getShootConfig();
        $data = [
            'striker' => $shootConfig->striker->id,
            'goalkeeper' => $shootConfig->goalkeeper->id,
            'attackHelperId' => $shootConfig->attackHelper ? $shootConfig->attackHelper->id : null,
            'defenseHelperId' => $shootConfig->defenseHelper ? $shootConfig->defenseHelper->id : null,
            'attackingTeamId' => $shootConfig->attackingTeamId,
            'defendingTeamId' => $shootConfig->defendingTeamId,
        ];
        $type = $result->isGoal() ? self::TYPE_GOAL : self::TYPE_SAVE;

        return new MatchEvent($type, $shootConfig->minute, $data);
    }

    /**
     * @return int|null
     */
    public function getStrikerId(): ?int
    {
        return $this->data['striker'] ?? null;
    }

    /**
     * @return bool
     */
    public function hasAttackHelper(): bool
    {
        return (bool)($this->data['attackHelperId'] ?? null);
    }

    /**
     * @return bool
     */
    public function hasDefenseHelper(): bool
    {
        return (bool)($this->data['defenseHelperId'] ?? null);
    }
}