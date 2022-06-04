<?php

declare(strict_types=1);

use OSM\Core\Models\Player;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT);

/**
 * @var Player $player;
 * @var bool $isOwner;
 */

echo 'This is player';

dd($player, $isOwner);