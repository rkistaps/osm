<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class MatchReport extends AbstractModel
{
    public const EVENT_TYPE_GOAL = 'goal';
    public const EVENT_TYPE_SAVE = 'save';
    public const EVENT_TYPE_ATTACK_STOP = 'attack-stop';
    public const EVENT_TYPE_INJURY = 'injury';
    public const EVENT_TYPE_YELLOW_CARD = 'yellow-card';
    public const EVENT_TYPE_SECOND_YELLOW_CARD = 'second-yellow-card';
    public const EVENT_TYPE_RED_CARD = 'red-card';
    public const EVENT_TYPE_PENALTY_GOAL = 'penalty-goal';
    public const EVENT_TYPE_PENALTY_SAVE = 'penalty-save';

    public const REPORT_TYPE_1V1_GOAL = 'one-vs-one-goal';
    public const REPORT_TYPE_1V1_SAVE = 'one-vs-one-save';
    public const REPORT_TYPE_1V2_GOAL = 'one-vs-two-goal';
    public const REPORT_TYPE_1V2_SAVE = 'one-vs-two-save';
    public const REPORT_TYPE_2V1_GOAL = 'two-vs-one-goal';
    public const REPORT_TYPE_2V1_SAVE = 'two-vs-one-save';
    public const REPORT_TYPE_2V2_GOAL = 'two-vs-two-goal';
    public const REPORT_TYPE_2V2_SAVE = 'two-vs-two-save';
    public const REPORT_TYPE_ATTACK_STOP = self::EVENT_TYPE_ATTACK_STOP;
    public const REPORT_TYPE_INJURY = self::EVENT_TYPE_INJURY;
    public const REPORT_TYPE_INJURY_WITH_A_SUB = 'injury-with-sub';
    public const REPORT_TYPE_YELLOW_CARD = self::EVENT_TYPE_YELLOW_CARD;
    public const REPORT_TYPE_SECOND_YELLOW_CARD = self::EVENT_TYPE_SECOND_YELLOW_CARD;
    public const REPORT_TYPE_PENALTY_GOAL = self::EVENT_TYPE_PENALTY_GOAL;
    public const REPORT_TYPE_PENALTY_SAVE = self::EVENT_TYPE_PENALTY_SAVE;
    public const REPORT_RED_CARD = self::EVENT_TYPE_RED_CARD;

    public int $matchId;
    public string $eventType;
    public string $reportType;
    public int $minute;
    public ?int $parentReportId;
    public int $matchReportTextId;
    public ?int $playerAId;
    public ?int $playerBId;
    public ?int $helperAId;
    public ?int $helperBId;
}
