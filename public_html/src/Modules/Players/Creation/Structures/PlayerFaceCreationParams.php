<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Structures;

use OSM\Core\Models\Player;

class PlayerFaceCreationParams
{
    public Player $player;
    public array $skinTones = [];
    public bool $canHaveFacialHair = true;
}
