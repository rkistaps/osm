<?php

declare(strict_types=1);

use OSM\Core\Models\Country;
use OSM\Core\Models\Player;
use OSM\Frontend\Helpers\BoxHelper;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT);

/**
 * @var Player $player;
 * @var Country $country;
 * @var bool $isOwner;
 */

$title = $player->getFullName() . ' (#' . $player->id . ')';

?>
<div class="row">
    <div class="col-7">
        <?php BoxHelper::start($title, ['id' => 'player']);?>
        <div class="row">
            <div class="col-5">
                <?=$this->fetch('/Player/_partials/face', ['player' => $player]);?>
            </div>
            <div class="col-7">info</div>
        </div>
        <?=BoxHelper::end();?>
    </div>
    <div class="col-5"></div>
</div>
