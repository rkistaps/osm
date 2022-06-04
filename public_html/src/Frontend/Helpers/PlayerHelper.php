<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use OSM\Core\Models\Player;

class PlayerHelper
{
    public static function getTalentStars(Player $player): string
    {
        return str_repeat(
            Html::img('/assets/images/star.png'),
            $player->talent
        );
    }
}