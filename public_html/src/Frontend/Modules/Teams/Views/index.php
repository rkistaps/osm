<?php

use OSM\Core\Models\Country;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;
use OSM\Frontend\Templates\LayoutTypes;

$this->layout(LayoutTypes::TYPE_DEFAULT);

/** @var Team $team */
/** @var User $user */
/** @var Country $country */

?>

<div class='box' id='team_overview'>
    <div class='title'>
        <span><?= $team->name ?></span>
    </div>
    <div class='content'>
        content
    </div>
</div>
