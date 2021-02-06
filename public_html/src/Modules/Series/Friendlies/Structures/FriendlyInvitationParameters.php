<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Friendlies\Structures;

use OSM\Core\Helpers\Traits\FromArrayTrait;

class FriendlyInvitationParameters
{
    use FromArrayTrait;

    public int $homeTeamId;
    public int $awayTeamId;
    public int $round;
}
