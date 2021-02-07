<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class FriendlyInvitation extends AbstractModel
{
    public const TYPE_TEAM = 'team';

    public string $type = self::TYPE_TEAM;
    public int $homeTeamId;
    public int $awayTeamId;
    public int $round;
    public bool $seen = false;
}
